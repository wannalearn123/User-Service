<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{
    /**
     * Mengecek token autentikasi sebelum request diproses controller.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        // Pastikan token ada di header (biasanya format: Bearer TOKEN) 
        if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return Services::response()
                ->setJSON([
                    'status' => 401,
                    'error' => 'Unauthorized',
                    'message' => 'Token autentikasi diperlukan untuk mengakses layanan ini.'
                ])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $token = $matches[1];

        // LOGIKA VALIDASI: Di sini kamu bisa cek ke database atau decode JWT 
        // untuk memastikan token tersebut benar-benar milik user yang valid[cite: 8, 9].
        if ($token !== "TOKEN_RAHASIA_DARI_LOGIN") { 
            return Services::response()
                ->setJSON([
                    'status' => 401,
                    'error' => 'Invalid Token',
                    'message' => 'Sesi Anda telah berakhir atau token tidak valid.'
                ])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biasanya dibiarkan kosong untuk filter autentikasi
    }
}
