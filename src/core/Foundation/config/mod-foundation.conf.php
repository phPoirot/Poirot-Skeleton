<?php
// TODO by this considered that themes always exists within www that seems ok when not using asset-manager
$themesFolder = trim(str_replace(PT_DIR_WWW, '', PT_DIR_THEME_DEFAULT), '/');

return array(
    // Path Helper Action Options
    \Module\Foundation\Actions\Helper\PathService::CONF_KEY
    => array(
        'paths' => array(
            'app-assets' => "\$basePath/{$themesFolder}/www",
        ),
    ),

    // View Renderer Options
    \Poirot\Application\Sapi\Server\Http\RenderStrategy\ListenersRenderDefaultStrategy::CONF_KEY
    => array(
        'default_layout'   => 'default',

        \Poirot\Application\Sapi\Server\Http\Service\ServiceViewModelResolver::CONF_KEY => array(
            /*
             * > Setup Aggregate Loader
             *   Options:
             *  [
             *    'attach' => [new Loader(), $priority => new OtherLoader(), ['loader' => iLoader, 'priority' => $pr] ],
             *    Loader::class => [
             *       // Options
             *       'Poirot\AaResponder'  => [APP_DIR_VENDOR.'/poirot/action-responder/Poirot/AaResponder'],
             *       'Poirot\Application'  => [APP_DIR_VENDOR.'/poirot/application/Poirot/Application'],
             *    ],
             *    OtherLoader::class => [options..]
             *  ]
             */
            'Poirot\Loader\LoaderNamespaceStack' => array(
                // Use Default Theme Folder To Achieve Views With Force First ("**")
                '**' => PT_DIR_THEME_DEFAULT,
            ),
        ),

        \Poirot\Application\Sapi\Server\Http\RenderStrategy\DefaultStrategy\ListenerError::CONF_KEY => array(
            ## full name of class exception

            ## use null on second index cause view template render as final layout
            // 'Exception' => ['error/error', null],
            // 'Specific\Error\Exception' => ['error/spec', 'override_layout_name_here']

            ## here (blank) is defined as default layout for all error pages
            'Exception' => array('error/error', 'blank'),
            'Poirot\Application\Exception\exRouteNotMatch' => 'error/404',
        ),
    ),
);