#Sentry

**Simple Laravel Resource Access Control**

## Usage
Sentry is a simple Laravel resource access control plugin that works without specifying resources.  The 
sentry_user_roles database table stores the relationship between the user and the user's roles.  Roles can be any 
arbitrary string that an organization chooses to use. Because this system does not care about resources, developers 
can validate a user's roles at any time simply by running a check of Sentry::hasRole("my_role").  The developer's 
script can continue or hault based on the boolean result of that check.  

Sentry requires knowledge of the user's roles before it is effective.  The best place to load Sentry with this 
information is immediately after the user has been authorized in your application; typically after logging in.  

**Example**

    public function doLogin() {
    
        $credentials = [
            'username' => 'foo',
            'password' => 'bar',
        ]
    
        if(Auth::attempt($credentials)) {

            // Retrieve SentryUserRoles from storage
            // Below is the Query way, but you can use
            // any other database driver.
            $table = DB::table('sentry_user_roles');
            $query = $table->where('user_id', "=", $user_id);
            $user_roles $query->lists('role');
            
            // Add user roles to Sentry
            Sentry::setUserRoles($user_roles);
            
            // Success Authentication
            return Redirect::intended('/');
            
        } else {
            
            // Fail Authentication
            return Redirect::route('login');
        }
    }
    
Once the developer has completed loading Sentry with the user roles, the developer no longer needs to perform this 
step.  

Validation is simple.  The developer can perform this anywhere, but the most common use-case is probably in a 
Controller's Action.  

**Example**

    class HomeController extends BaseController {
    
        public function myAdminAction() {
        
            // Sentry::requireRole accepts a string, or an array
            // String usage is below
            $isAllowed = Sentry::requireRole('admin');
    
            if($isAllowed) {
                dd("Success, I'm allowed to do this!");
            }
            dd("Bummer, I am not allowed to do this...");
        }
        
        public function myPowerUserAction() {
        
            // Sentry::requireRole accepts a string, or an array
            // Array usage is below
            $isAllowed = Sentry::requireRole(['sales', 'sales_admin', 'sales_intern']);
    
            if($isAllowed) {
                dd("Success, I'm allowed to do this!");
            }
            dd("Bummer, I am not allowed to do this...");
        }
    }
    
Instead of passing a string or an array to _Sentry::requireRole()_, a developer can allow Roles by using the 
**Sentry::allowFooRole** magic method. A third way of allowing roles is to use _Sentry::allow("foo_role")_. If the 
developer chooses this method, then he or she can call _Sentry::requireRole()_ without any parameters.  

**Example**

    Sentry::allowUser();
    Sentry::allowGuest();
    $isAllowed = Sentry::requireRole();
    
is the same as 

    $isAllowed = Sentry::requireRole(['user', 'guest']);
    
which is the same as 

    Sentry::allow('user');
    Sentry::allow('guest');
    $isAllowed = Sentry::requireRole();
    
Additionally, the configuration file for this package includes the parameter _super_admin_.  The role assigned to 
this key will **always** be allowed whenever _Sentry::requireRole()_ is invoked.  In other words, 
_Sentry::requireRole()_ will return TRUE for users who's roles include the value that matches the value in 
_super_admin_.

**Example**

    // config/packages/wesleyalmeida/sentry/config.php
        'super_admin' => 'admin',
    
    
    // login action
        // User Roles
        $user_roles = ['user', 'sales', 'admin']
        // Add user roles to Sentry
        Sentry::setUserRoles($user_roles);
    
    // someAction()
        $isAllowed = Sentry::requireRole(); // returns true
        
**Final Note**
1. The user roles are not case sensitive.  All user roles are normalized to lowercase as soon as the developer 
provides them to _Sentry_.  Underscores are not converted to camelCase. Therefore, _salesAdmin_ is the same as 
_salesadmin_, but neither are the same as _sales_admin_.
  
2. _Sentry_ uses the Session to store the user roles.  If you want to store the user roles in the Auth::user() 
object, you can do so by adding the following method to the User object that your UserProvider class demands

**Sample**

    // Eloquent User
    public function roles() {
        $this->hasMany('SentryUserRoles', 'user_id', 'id); // SentryUserRoles must also be an Eloquent model
    }
    
    // Using QueryBuilder
    public function roles() {
        $table = DB::table('sentry_user_roles');
        
        $query = $table->where('user_id', "=", $user_id);

        return $query->lists('role');
    }

## Installation

### Composer
    
    "require": {
        "wesleyalmeida/sentry": "dev-master"
    },
    "repositories": [
        { "type": "vcs", "url": "git@github.com:wesleyalmeida/sentry.git" }
    ],
    
### Configuration File
    
    php artisan config:publish wesleyalmeida/sentry"

### Database Table 

    php artisan migrate --package="wesleyalmeida/sentry"
   
