Synthetic Revision managements system is a data tracking system that can track history in your previous data changes.
in this package has following features.

 1. dynamic table create for revision.
 2. can set prefix for table.
 3. can set number of row limit.

**How to install Synthetic Revision**

    composer require yosuite/synthetic-revisions
**Publish configuration**

    php artisan vendor:publish --tag=synthetic-revisions

**Add Trait in your model**

    use \SyntheticRevisions\Trait\RevisionableTrait;
    use RevisionableTrait;
**Example**

    <?php
	    namespace  App\Models;
	    use Illuminate\Database\Eloquent\Factories\HasFactory;
	    // use Illuminate\Database\Eloquent\Model;
	    use \SyntheticRevisions\Trait\RevisionableTrait; //trait
	    use MongoDB\Laravel\Eloquent\Model;
	    
	    class  Document  extends  Model {
		    use  HasFactory, RevisionableTrait; //use trait here
		    protected $fillable = [
			    'name', 'description', 'user_id'
		    ];
	    }
all done. now you can see your changed data after change or create.

use compare() method to get previous record. And you need to pass your model class name like **compare(Document::class)**

    Document::find('65238c45f2843e654b0bdfce')->revisions()->limit(1)->get()->compare(Document::class);
    
**Output sample**
![sample response](https://i.ibb.co/1ntpVjm/Screenshot-2023-10-09-141608.png)