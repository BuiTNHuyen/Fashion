# Hướng dẫn thiết lập hệ thống gợi ý sản phẩm tự động

## 1. Cấu hình đã hoàn thành

✅ **Auto Train Real-time**: Model tự động train ngay khi có dữ liệu mới
✅ **Logic thông minh**: Chỉ train khi cần thiết
✅ **Command kiểm tra**: Có thể theo dõi trạng thái hệ thống


## 2. Thiết lập

### Không cần thiết lập gì thêm!
- ✅ **Auto train hoạt động tự động** khi có dữ liệu mới
- ✅ **Không cần cron job** - không có schedule định kỳ
- ✅ **Không cần cấu hình phức tạp** - chỉ cần bật auto train
- ✅ **Không có định kỳ** - chỉ train khi có dữ liệu mới

## 3. Kiểm tra hoạt động

### Kiểm tra trạng thái hệ thống:
```bash
php artisan recommendation:status
```



### Train thủ công (nếu cần):
```bash
php artisan recommendation:train --force
```

## 4. Cách hoạt động

### Auto Train Real-time:
1. Khi có dữ liệu mới (review, view, favorite, order)
2. Observer tự động được kích hoạt
3. Kiểm tra xem auto train có được bật không
4. Nếu có dữ liệu mới trong 1 phút qua → train model ngay lập tức
5. Sử dụng lock để tránh train đồng thời

### Lưu ý:
- **Không có schedule định kỳ** - chỉ train khi có dữ liệu mới
- **Tiết kiệm tài nguyên** - không train không cần thiết
- **Cập nhật ngay lập tức** - gợi ý luôn mới nhất
- **Luôn bật** - auto train luôn hoạt động

### Dữ liệu được theo dõi:
- **Reviews**: Đánh giá sản phẩm
- **Views**: Lượt xem sản phẩm  
- **Favorites**: Sản phẩm yêu thích
- **Orders**: Đơn hàng đã mua

## 5. Tối ưu hóa hiệu suất

### Ưu điểm của hệ thống:
- ✅ **Real-time**: Train ngay khi có dữ liệu mới
- ✅ **Thông minh**: Chỉ train khi cần thiết
- ✅ **Tiết kiệm**: Tiết kiệm tài nguyên server tối đa
- ✅ **Cập nhật**: Gợi ý luôn cập nhật với dữ liệu mới nhất
- ✅ **Đơn giản**: Không cần cấu hình phức tạp
- ✅ **Tự động**: Luôn hoạt động khi có dữ liệu mới

### Lưu ý:
- Model được lưu trong `storage/app/recommendation_model.rbx`
- Metadata được lưu trong `recommendation_metadata.json`
- Log được ghi vào `storage/logs/laravel.log`

## 6. Troubleshooting

### Nếu cron không hoạt động:
```bash
# Kiểm tra cron service
sudo service cron status

# Khởi động cron service
sudo service cron start

# Kiểm tra log cron
sudo tail -f /var/log/cron
```

### Nếu auto train không hoạt động:
```bash
# Kiểm tra trạng thái hệ thống
php artisan recommendation:status

# Kiểm tra quyền thư mục
chmod -R 755 /c/xampp/htdocs/cosmetics
chmod -R 777 /c/xampp/htdocs/cosmetics/storage
```

### Nếu model không train:
```bash
# Kiểm tra trạng thái
php artisan recommendation:status

# Force train
php artisan recommendation:train --force

# Kiểm tra log
tail -f storage/logs/laravel.log
```

## 7. Monitoring

### Theo dõi hoạt động:
```bash
# Xem log real-time
tail -f storage/logs/laravel.log

# Kiểm tra trạng thái định kỳ
php artisan recommendation:status

# Kiểm tra trạng thái auto train
php artisan recommendation:auto-train status
```

### Metrics quan trọng:
- Số lượng user có dữ liệu
- Số lượng sản phẩm được tương tác
- Tổng số tương tác
- Thời gian train cuối cùng
- Dữ liệu mới trong 1 phút qua 