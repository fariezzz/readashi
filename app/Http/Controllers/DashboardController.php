<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $products = Product::all();
        $borrowings = Borrowing::all();

        $productsPerCategory = Category::withCount('products')
            ->get()
            ->map(fn ($category) => [
                'label' => $category->name,
                'total' => $category->products_count,
            ]);

        $statusMap = ['borrowed' => 0, 'returned' => 0, 'late' => 0];
        foreach ($borrowings as $borrowing) {
            if (array_key_exists($borrowing->status, $statusMap)) {
                $statusMap[$borrowing->status]++;
            }
        }

        $monthLabels = [];
        $monthlyTotals = [];
        $startMonth = now()->startOfMonth()->subMonths(5);
        for ($i = 0; $i < 6; $i++) {
            $monthKey = $startMonth->copy()->addMonths($i)->format('Y-m');
            $monthLabels[] = Carbon::createFromFormat('Y-m', $monthKey)->format('M Y');
            $monthlyTotals[$monthKey] = 0;
        }

        foreach ($borrowings as $borrowing) {
            if (empty($borrowing->borrow_date)) {
                continue;
            }
            $monthKey = Carbon::parse($borrowing->borrow_date)->format('Y-m');
            if (array_key_exists($monthKey, $monthlyTotals)) {
                $monthlyTotals[$monthKey]++;
            }
        }

        return view('pages.index', [
            'title' => 'Dashboard',
            'users' => $users,
            'products' => $products,
            'borrowings' => $borrowings,
            'productsPerCategoryLabels' => $productsPerCategory->pluck('label')->values(),
            'productsPerCategoryData' => $productsPerCategory->pluck('total')->values(),
            'borrowingStatusLabels' => ['Borrowed', 'Returned', 'Late'],
            'borrowingStatusData' => [
                $statusMap['borrowed'],
                $statusMap['returned'],
                $statusMap['late'],
            ],
            'monthlyBorrowingLabels' => $monthLabels,
            'monthlyBorrowingData' => array_values($monthlyTotals),
        ]);
    }
}
