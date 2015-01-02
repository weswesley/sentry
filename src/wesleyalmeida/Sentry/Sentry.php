<?php
/**
 * Author: Wesley
 * Date: 30-Dec-14
 * Time: 18:08
 */

namespace Wesleyalmeida\Sentry;

class Sentry {

    protected $allowed    = array();
    protected $defaults   = array();
    protected $user_roles = array();

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role = "") {

        $role = strtolower($role);

        if (in_array($role, $this->user_roles)) {
            $this->clearAllowed();
            return true;
        }
        $this->clearAllowed();
        return false;
    }

    /**
     * @param mixed $roles
     *
     * @return bool
     */
    public function requireRole($roles = "") {

        if (is_array($roles)) {
            $allowed = array_merge($this->allowed, $roles);
        } else {
            $allowed   = $this->allowed;
            $allowed[] = $roles;
        }

        foreach ($allowed as $role) {
            $hasRole = $this->hasRole($role);
            if ($hasRole) {
                return true;
            }
        }

        return false;
    }


    /**
     * @param mixed $roles
     *
     * @return bool
     */
    public function isAllowed($roles = "") {

        return $this->requireRole($roles);
    }

    /**
     * @return array
     */
    public function getUserRoles() {
        return $this->user_roles;
    }

    /**
     * @return array
     */
    public function getAllowed() {
        return $this->allowed;
    }

    /**
     * @return string
     */
    public function toJson() {
        return json_encode($this->user_roles);
    }

    /**
     * @param $method
     * @param $args
     *
     * @return bool
     * @throws \Exception
     */
    public function __call($method, $args) {

        if (substr($method, 0, 5) === "allow") {

            $property = strtolower(substr($method, 5));

            return $this->allow($property);
        }

        if (substr($method, 0, 4) === "deny") {
            $property = strtolower(substr($method, 4));

            return $this->deny($property);
        }

        throw new \Exception("$method function does not exist");

    }

    /**
     * @param string $allow
     *
     * @return bool
     */
    public function allow($allow) {

        $this->allowed[] = $allow;

        return true;
    }

    /**
     * @param string $property
     *
     * @return bool
     */
    public function deny($deny) {
        $key = array_search($deny, $this->allowed);

        if ($key) {
            unset($this->allowed[$key]);
        }

        $this->allowed = array_values($this->allowed);

        return true;
    }

    /**
     * @param array $user_roles
     *
     * @throws \Exception
     */
    public function setUserRoles($user_roles) {
        if (!is_array($user_roles)) {
            throw new \Exception("Invalid user roles. Sentry requires an array.");
        }

        foreach ($user_roles as $role) {
            $this->user_roles[] = strtolower($role);
        }
    }

    /**
     * @param array $defaults
     */
    public function setDefaults($defaults) {
        $this->defaults = $defaults;

        $this->allow(strtolower($defaults['super_admin']));
    }

    /**
     * Resets the allowed roles to the defaults
     */
    public function clearAllowed() {

        $this->allowed = [];

        $this->allow($this->defaults['super_admin']);
    }

}