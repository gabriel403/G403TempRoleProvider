<?php

namespace G403TempRoleProvider\Provider\Identity;

use BjyAuthorize\Provider\Identity\ProviderInterface;
use Zend\Session\Container;

class Temp implements ProviderInterface
{
    /**
     * @var ProviderInterface
     */
    protected $mainProvider;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Add a temporary role
     * @param string $role the role to add
     *
     * @return ProviderInterface
     */
    public function addTempRole($role)
    {
        $session = $this->getContainer();
        if ( !$session->offsetExists('roles') )
        {
            $session->offsetSet('roles', []);
        }
        $roles   = $session->offsetGet('roles');
        if ( false === array_search($role, $roles) )
        {
            $roles[] = $role;
            $session->offsetSet('roles', $roles);
        }

        return $this;
    }

    /**
     * Remove a temporary role
     * @param  string $role the role to remove
     *
     * @return ProviderInterface
     */
    public function remTempRole($role)
    {
        $session = $this->getContainer();
        if ( !$session->offsetExists('roles') )
        {
            return $this;
        }
        $roles   = $session->offsetGet('roles');
        if ( false === array_search($role, $roles) )
        {
            return $this;
        }

        unset($roles[array_search($role, $roles)]);
        $session->offsetSet('roles', $roles);

        return $this;
    }

    /**
     * Clear all temporary roles
     *
     * @return ProviderInterface
     */
    public function clearTempRoles()
    {
        $session->offsetSet('roles', []);

        return $this;
    }

    public function getIdentityRoles()
    {
        $roles  = $this->getMainProvider()->getIdentityRoles();
        $nroles = [];

        $session = $this->getContainer();

        if ( $session->offsetExists('roles') ) {
            $nroles = $session->offsetGet('roles');
            if ( !is_array($nroles) ) {
                $nroles = [$nroles];
            }
        }

        return array_merge($nroles,$roles);
    }

    /**
     * Get the composite provider
     *
     * @return ProviderInterface
     */
    public function getMainProvider()
    {
        return $this->mainProvider;
    }

    /**
     * Set the provider to use as it's composite
     *
     * @param ProviderInterface $mainProvider
     */
    public function setMainProvider(ProviderInterface $mainProvider)
    {
        $this->mainProvider = $mainProvider;
        return $this;
    }

    /**
     * Get the session container
     *
     * @return Container
     */
    public function getContainer()
    {

        if ($this->container instanceof Container) {
            return $this->container;
        }

        $this->container = new Container('TIP');

        return $this->container;
    }

    /**
     * Sets the session container
     *
     * @param Container $Container
     *
     * @return ProviderInterface
     */
    public function setContainer(Container $Container)
    {
        $this->container = $container;
        return $this;
    }
}