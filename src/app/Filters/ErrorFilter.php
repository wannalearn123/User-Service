<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ErrorFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Tidak ada pengecekan di awal
    }

    /**
     * Memastikan response status code error tetap dikirim sebagai JSON.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 400) {
            // Jika response belum berbentuk JSON, kita ubah di sini
            if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === false) {
                return $response->setJSON([
                    'status'  => $statusCode,
                    'message' => 'Terjadi kesalahan pada sistem atau endpoint tidak ditemukan.'
                ]);
            }
        }
    }
}
