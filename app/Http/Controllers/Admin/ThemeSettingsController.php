namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class ThemeSettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.theme', [
            'defaultTheme' => SiteSetting::get('theme.default', 'light'),
            'allowOverride' => SiteSetting::get('theme.allow_user_override', 'true'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'theme_default' => 'required|in:light,dark,system',
            'allow_override' => 'required|boolean',
        ]);

        SiteSetting::set('theme.default', $request->theme_default);
        SiteSetting::set('theme.allow_user_override', $request->allow_override ? 'true' : 'false');

        return back()->with('success', 'Theme settings updated successfully.');
    }
}
