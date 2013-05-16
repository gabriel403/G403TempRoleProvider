<?php

namespace G403TempRoleProvider\Service;

class Temp
{
	protected $tempRoleProvider;

	/**
	 * Add a temporary role
	 *
	 * @param string $role
	 */
	public function addTempRole($role)
	{
		$this->getTempRoleProvider()->addTempRole($role);
	}

	/**
	 * Clear all temporary roles
	 *
	 */
	public function clearTempRoles()
	{
		$this->getTempRoleProvider()->clearTempRoles();
	}

	/**
	 * remove a single temporary role
	 *
	 * @param  string $role
	 */
	public function remTempRole($role)
	{
		$this->getTempRoleProvider()->remTempRole($role);
	}



	/**
	 * Getter for tempRoleProvider
	 *
	 * @return mixed
	 */
	public function getTempRoleProvider()
	{
	    return $this->tempRoleProvider;
	}

	/**
	 * Setter for tempRoleProvider
	 *
	 * @param mixed $tempRoleProvider Value to set
	 *
	 * @return self
	 */
	public function setTempRoleProvider($tempRoleProvider)
	{
	    $this->tempRoleProvider = $tempRoleProvider;
	    return $this;
	}


}