<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Mpdf;

class PrinterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $orderId)
    {
        $order = Order::query()
            ->with('items')
            ->findOrFail($orderId);

        $currencySymbol = config('settings.currency_symbol', 'XOF');

        $siteName = config('settings.site_name');
        $siteDescription = config('settings.site_description');

        $data = [
            'invoiceNumber' => $order->id,
            'date' => $order->created_at->format('M d, Y'),
            'time' => $order->created_at->format('h:i:s A'),
            'items' => $order->items,
            'order' => $order,
            'currencySymbol' => $currencySymbol,
            'siteName' => $siteName,
            'siteDescription' => $siteDescription
        ];

        $html = view('invoices.invoice', $data)->render();

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                public_path(''),
            ]),
            'fontdata' => $fontData + [
                'terminus' => [
                    'R' => 'Terminus.ttf',
                ]
            ],
            'default_font' => 'terminus',
            'mode' => 'utf-8',
            'shrink_tables_to_fit' => 0,
            'format' => [75, 200],
            'orientation' => 'P',
            'margin_left' => 3,
            'margin_right' => 3,
            'margin_top' => 3,
            'margin_bottom' => 3,
        ]);

        $mpdf->WriteHTML($html);

        return $mpdf->Output('invoice-' . $orderId . '.pdf', 'I');
    }
}
