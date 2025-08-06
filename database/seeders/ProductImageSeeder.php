<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        // Lấy danh sách tất cả sản phẩm
        $products = Product::all();
        
        // Danh sách ảnh có sẵn
        $availableImages = [
            'products/xEFeTMXqW579rpUU3vbFDgCbiAZ1YrkSjYZUutWp.jpg',
            'products/ryadHnrcbzLEFeWcJnlPjZCZTpS3I7KGjD7CUWjl.jpg',
            'products/svMnX5yYrf5xv6XAUfegT0xVz774N5jIMJxSKw0S.webp',
            'products/BeTHFB6ceqxPU5YkO0ZUrFVpTdN3f0sIvBIbT22S.webp',
            'products/tdiT6P03Aph8CuBreLBioEd0RsxkpLzkOKhTnbH8.webp',
            'products/p5P3QM8DVcBgpIoT0qyWDJolrUGYhFPNoyUTpfDT.webp',
            'products/3RmsApDhJc6TMwYS1S9PTECsbU1cNdmAOjR05DOX.webp',
            'products/MAidsWW5yzUNLxikYDhD19fliBwGgvOe7Zbkzohj.webp',
            'products/BeCjZzdeCt0yWpLz8Yrc3rHZJb1eijksHUpL16Gb.webp',
            'products/CGXGlKyI2xyDfcNmmIFDwo8HbXsxZNwVt7BntVmU.jpg',
        ];

        foreach ($products as $product) {
            // Xóa ảnh cũ nếu có
            $product->images()->delete();
            
            // Thêm 2-4 ảnh ngẫu nhiên cho mỗi sản phẩm
            $numberOfImages = rand(2, 4);
            $selectedImages = array_rand(array_flip($availableImages), $numberOfImages);
            
            if (!is_array($selectedImages)) {
                $selectedImages = [$selectedImages];
            }
            
            foreach ($selectedImages as $imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                ]);
            }
        }
    }
} 