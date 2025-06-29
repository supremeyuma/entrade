namespace App\Http\Controllers\Admin;

use App\Models\UserWallet;
use App\Http\Controllers\Controller;

class AdminWalletController extends Controller
{
    public function index()
    {
        $wallets = UserWallet::with('user')->latest()->paginate(20);
        return view('admin.wallets.index', compact('wallets'));
    }
}
