<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;



class DashboardMetricsService
{
    public function totalRevenue(){
        return Cache::remember('dashboard.total_revenue',60,function(){
            return DB::table('invoices')
                ->where('status','paid')
                ->sum('total');
        });
    }

    public function outstandingBalance(){
        return Cache::remember('dashboard.outstanding_balance',60,function(){
            return DB::table('invoices')
                ->whereIn('status',['sent','partial','overdue'])
                ->sum(DB::raw('total - COALESCE(amount_paid, 0)'));
        });
    }

    public function overdueInvoicesCount(){
        return Cache::remember('dashboard.overdue_count',60,function(){
            return DB::table('invoices')
                ->where('status','overdue')
                ->count();
        });
    }

    public function totalClients(){
        return Cache::remember('dashboard.total_clients',60,function(){
            return DB::table('clients')->count();
        });
    }

    public function revenueComparison(){
        return Cache::remember('dashboard.revenue_comparison',60,function (){
            $thisMonth = DB::table('invoices')
                ->where('status','paid')
                ->whereMonth('created_at',now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total');

            $lastMonth = DB::table('invoices')
                ->where('status','paid')
                ->whereMonth('created_at',now()->subMonth()->month)
                ->whereYear('created_at', now()->subYear()->year)
                ->sum('total');

            return [
                'thisMonth' => $thisMonth,
                'lastMonth' => $lastMonth,
                'difference' => $thisMonth - $lastMonth,
            ];
        });
    }
    
    public function recentInvoices(){
        return Cache::remember('dashboard.recent_invoices',60,function(){
            
        });

    }

    public function topClientsByBalance()
    {
        return Cache::remember('dashboard.top_clients', 60, function () {
            return DB::table('invoices')
                ->join('clients', 'invoices.client_id', '=', 'clients.id')
                ->select(
                    'clients.id',
                    'clients.name',
                    DB::raw('SUM(invoices.total - COALESCE(invoices.amount_paid, 0)) as balance')
                )
                ->whereIn('invoices.status', ['sent', 'partial', 'overdue'])
                ->groupBy('clients.id', 'clients.name')
                ->orderByDesc('balance')
                ->limit(5)
                ->get();
        });
    }

    public function dueSoonInvoices(){ 
        return Cache::remember('dashboard.due_soon',60,function(){ 
            return Invoice::with('client') 
                ->whereBetween('due_date',[ 
                    now(), 
                    now()->addDays(7) 
                ]) 
            ->whereIn('status',['sent','partial']) 
            ->orderBy('due_date') 
            ->get(); 
        });
    }
}