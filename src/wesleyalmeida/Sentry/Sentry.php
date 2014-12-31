<?php
/**
 * Author: Wesley
 * Date: 30-Dec-14
 * Time: 18:08
 */

namespace Wesleyalmeida\Sentry;


class Sentry {

    protected $user_roles = array();

    static public function make($user_roles) {

        return new Sentry($user_roles);
    }

    public function __construct($user_roles) {

        foreach($user_roles as $role) {
            $this->user_roles[] = strtolower($role);
        }
    }

    public function hasRole($role) {

        $role = strtolower($role);

        if(in_array($role, $this->user_roles)) {

            return true;
        }

        return false;
    }

    public function requireRole($role) {
        if(is_array($role)) {
            foreach($role as $value) {
                $hasRole = $this->hasRole($value);

                if ($hasRole) {
                    return true;
                }
            }
        } else {
            return $this->hasRole($role);
        }

        return false;
    }

    public function roles() {
        return $this->getRoles();
    }

    public function getRoles() {
        return $this->user_roles;
    }

    public function toJson() {
        return json_encode($this->user_roles);
    }

    public function hello() {
        dd("Hello, I'm your Sentry");
    }

    public function __call($method, $args) {

        if(substr($method, 0, 5) === "allow") {

            $property = strtolower(substr($method, 5));

            return $this->allow($property);
        }

        if(substr($method, 0, 8) === "disallow") {
            $property = strtolower(substr($method, 8));

            return $this->disallow($property);
        }

        throw new \Exception("$method function does not exist");

    }

    public function allow($allow) {

        $this->user_roles[] = $allow;

        return true;
    }

    public function disallow($property) {
        $key = array_search($property, $this->user_roles);

        unset($this->user_roles[$key]);

        $this->user_roles = array_values($this->user_roles);

        return true;
    }

    public function prevent($property) {

        return $this->disallow($property);

    }


}