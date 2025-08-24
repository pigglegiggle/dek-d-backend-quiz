# 📌 Dek-D Backend quiz

## ฐานข้อมูล (Database)  
ก่อนใช้งานโปรเจกต์นี้ ให้สร้างฐานข้อมูลและตารางตามโค้ดด้านล่าง  

```sql
-- สร้างฐานข้อมูล
CREATE DATABASE blog;

-- สร้าง table บล็อก (blogs)
CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
);
```
