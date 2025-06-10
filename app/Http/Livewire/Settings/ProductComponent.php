<?php

namespace App\Http\Livewire\Settings;

use App\Models\Settings\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $ProductIDs = [];

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'name';

    public $orderAsc = 1;

    public $name;

    public $type;

    public $is_active;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|unique:products',
        ]);
    }

    public function addEntry()
    {
        $this->createNew = true;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:products',
        ]);

        $product = new Product();
        $product->name = $this->name;
        $product->type = $this->type;
        $product->is_active = $this->is_active;
        $product->created_by = \Auth::user()->id;
        $product->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Product added successfully!']);
    }

    public function editData(Product $product)
    {
        $this->edit_id = $product->id;
        $this->name = $product->name;
        $this->type = $product->type;
        $this->is_active = $product->is_active;

        $this->createNew = false;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name', 'type', 'is_active']);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:products,name,'.$this->edit_id.'',
            'type' => 'required',
            'is_active' => 'required',
        ]);

        $product = Product::find($this->edit_id);
        $product->name = $this->name;
        $product->type = $this->type;
        $product->is_active = $this->is_active;
        $product->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Product updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->ProductIDs) > 0) {
            return (new ProductsExport($this->ProductIDs))->download('lss_products'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No products selected for export!',
            ]);
        }
    }

    public function filterProducts()
    {
        $products = Product::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->productIDs = $products->pluck('id')->toArray();

        return $products;
    }

    public function render()
    {

        $data['products'] = Product::search($this->search)
            ->when($this->is_active, function ($query) {
                $query->where('is_active', $this->is_active);
            })->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.settings.products-component', $data);
    }
}
