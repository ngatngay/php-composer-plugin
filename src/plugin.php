<?php

namespace nightmare\composer_plugin;

use Composer\Plugin\PluginInterface;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class composer_plugin implements PluginInterface, EventSubscriberInterface
{
    public function activate(\Composer\Composer $composer, \Composer\IO\IOInterface $io) {}
    public function deactivate(\Composer\Composer $composer, \Composer\IO\IOInterface $io) {}
    public function uninstall(\Composer\Composer $composer, \Composer\IO\IOInterface $io) {}

    public static function getSubscribedEvents()
    {
        return [
            'post-install-cmd' => 'create_htaccess',
            'post-update-cmd'  => 'create_htaccess'
        ];
    }

    public function create_htaccess(Event $event)
    {
        $vendor_dir = $event->getComposer()->getConfig()->get('vendor-dir');
        $htaccess_path = $vendor_dir . '/.htaccess';
        $content = "Require all denied";

        file_put_contents($htaccess_path, $content);
        $event->getIO()->write("<info>created .htaccess in $vendor_dir</info>");
    }
}
