# Setup
* Clone and install the repository using the standard laravel install guide
* Create database, migrate and seed: `php artisan migrate:fresh --seed`
* Generate a password client for passport: `php artisan passport:client --password` 

# Note about implementation
I appreciate that the requirements of this task do not require a repository design and the response class is perhaps 
over the top, but this is the path I would take to build an API. If I was to continue developing this application,
these helpful setup steps would help put it together quicker in my opinion. 
