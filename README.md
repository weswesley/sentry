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
            // Below is the Eloquent way, but you can use
            // any other database driver.
            $user_roles = TODO::
            
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

## Installation

### Composer
    
    "require": {
        "wesleyalmeida/sentry": "dev-master"
    },
    "repositories": [
        { "type": "vcs", "url": "git@github.com:wesleyalmeida/sentry.git" }
    ],

### Database Table 

    php artisan migrate --package="wesleyalmeida/sentry"
   
