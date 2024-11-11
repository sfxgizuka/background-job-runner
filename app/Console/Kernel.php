namespace App\Console;

use App\Console\Commands\RunBackgroundJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        RunBackgroundJob::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Schedule tasks here if needed
    }

    public function bootstrap()
    {
        parent::bootstrap();
        // Register any custom services or helpers if required
    }
}
