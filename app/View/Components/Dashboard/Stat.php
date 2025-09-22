namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class Stat extends Component
{
    public $label;
    public $count;
    public $icon;
    public $color;

    public function __construct($label = '', $count = 0, $icon = 'bar-chart', $color = 'text-gray-600')
    {
        $this->label = $label;
        $this->count = $count;
        $this->icon = $icon;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.dashboard.stat');
    }
}
