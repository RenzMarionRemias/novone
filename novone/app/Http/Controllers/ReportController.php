<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


use App\Log;
use App\ProductPullOut;
use App\Store;
use App\User;


use DB;
use Storage;
use Session;

class ReportController extends Controller {

    public function getCriticalLevelProducts(Request $request){

        $result = DB::select(DB::raw("SELECT product.product_code,product.product_name,product.critical_level,inventory.quantity
        FROM products as product,inventories as inventory 
        WHERE product.product_code = inventory.product_code AND inventory.quantity <= product.critical_level"));

        return response()->json($result);
    }

    public function topProducts (Request $request){

        $result = DB::select(DB::raw("SELECT products.product_code,products.product_name,sum(invoice_details.purchase_quantity) as total_bundle,
        sum(invoices.invoice_total_amount) as total_sales
        FROM products, invoice_details, invoices
        WHERE
        products.product_code = invoice_details.product_code AND 
        invoices.payment_status = 'PAID' 
        GROUP BY 
        products.product_code,products.product_name LIMIT 10"));

        return response()->json($result);
    }

    public function filterSales(Request $request) {
    
    if($request->query('type') != 'range'){
        $type = strtoupper($request->query('type'));
        
                $result =  DB::table('invoices')
                    ->where('delivery_status', 'DELIVERED')
                    ->select(DB::raw('SUM(invoice_total_amount) as total'),DB::raw(''.$type.'(created_at) as date'))
                    ->groupBy(DB::raw(''.$type.'(created_at)'))
                    ->limit(5)
                    ->get()
                    ->toArray();
    }
    else{
        $result =  DB::table('invoices')
                    ->where('delivery_status', 'DELIVERED')
                    ->where('created_at', '>=', $request->start)
                    ->where('created_at', '<=', $request->end)
                    ->select(DB::raw('SUM(invoice_total_amount) as total'),DB::raw('(created_at) as date'))
                    ->groupBy(DB::raw('(created_at)'))
                    ->limit(5)
                    ->get()
                    ->toArray();
    }

            return response()->json($result);
    }

    public function filterClients(Request $request) {
        
        $result =  DB::table('clients')
            ->where('created_at', '>','DATE(NOW())  - INTERVAL 6 MONTH')
            ->select(DB::raw('COUNT(client_id) as client'),DB::raw('MONTH(created_at) as date'))
            ->orderBy('created_at','asc')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->limit(12)
            ->get()
            ->toArray();
            
            return response()->json($result);
    }


    /*

    SELECT SUM(invoice_total_amount) AS entries, 
    DATE(created_at) as date FROM invoices 
    WHERE delivery_status = 'DELIVERED' AND 
    created_at > DATE(NOW()) - INTERVAL 7 DAY GROUP BY DATE(created_at) LIMIT 0 , 30
    */

    // PAGES

    public function showReports(){
        return view('admin.partials.reports.sales');
    }

}