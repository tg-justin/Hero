<?PHP
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LevelUpNotificationMiddleware
{
	public function handle(Request $request, Closure $next)
	{
		if (auth()->check())
		{
			$user = auth()->user();
			if ($user->level > $user->last_notified_level)
			{ // Check against the session
				$message = "Congratulations! You've reached level " . $user->level . "!";
				session()->flash('level_up_message', $message);

				// Update last_notified_level and the session
				$user->last_notified_level = $user->level;
				$user->save();
			}
			else
			{
				session()->forget('level_up_message');
			}
		}
		return $next($request);
	}
}
