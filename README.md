MinimalOriginal MenuBundle
========

The menu bundle for Minimal

Register bundle
========
$bundles = [
    ...
    new MinimalOriginal\MenuBundle\MinimalMenuBundle(),
];

Register routes
========
minimal_menu:
    resource: "@MinimalMenuBundle/Resources/config/routing.yml"
    prefix:   /

Command to launch
========
bin/console minimal_menu:create-first-menu
