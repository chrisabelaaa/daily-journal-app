
use App\Models\Journal;
use App\Policies\JournalPolicy;
use App\Models\Activity;
use App\Policies\ActivityPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Journal::class => JournalPolicy::class,
        Activity::class => ActivityPolicy::class,
    ];

    public function boot()
    {
        parent::boot();
    }
}