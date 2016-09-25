<?php

namespace akerbel\ManagerBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Create manager Sidebar Menu
     */
    public function managerSidebarMenu(FactoryInterface $factory, array $options)
    {
        $em = $this->container->get('doctrine')->getManager();
        
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'manager'));

        $menu->addChild('Albums', array('route' => 'album'));
        
        $albums = $em->getRepository('akerbelManagerBundle:Album')->findAll();
        
        foreach ($albums as $album){
            $menu['Albums']->addChild($album->getTitle(), array(
                'route' => 'album_show', 
                'routeParameters' => array('id' => $album->getId())
            ));
            $menu['Albums'][$album->getTitle()]->addChild('Edit', array(
                'route' => 'album_edit', 
                'routeParameters' => array('id' => $album->getId())
            ));
        }
        
        $menu->addChild('Settings', array('route' => 'settings'));

        return $menu;
    }
}
