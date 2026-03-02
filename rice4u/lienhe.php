

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
     <link rel="stylesheet" href="./header.css">
     <link rel="stylesheet" href="./footer.css">
     <link rel="stylesheet" href="./lienhe.css">
    <title>Liên Hệ</title>
</head>
<body>
      <header class="header" id="header-placeholder"></header>
   <main>
    <div class="info">
        <h3>Thông tin cửa hàng</h3>
        <p class="content"> Rice4u chuyên cung cấp các loại gạo đặc sản vùng miền, 
            đảm bảo chất lượng và an toàn thực phẩm cho mọi gia đình Việt.</p>
  </div>
    <section class="contact">
        <form class="form" action="gui_lienhe.php" method="post">
            <fieldset>
               <h3>Gửi lời nhắn</h3>
               <div class="form-group">
                <div class="row1">
                    <div class="col-1">Họ và tên
                        <input type="text" id="name" name="name" placeholder="Nhập tên của bạn">
                    </div>
                    <div class="col-2">Số điện thoại
                        <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại của bạn">
                    </div>
                </div>
                <div class="row2">
                    <div class="col-1">Email
                       <input type="email" id="email" name="email" placeholder="Nhập email của bạn">
                      
                    </div>
                </div>
                <div class="row3">
                    <div class="col-1">Nội dung
                        <textarea id="message" name="message" row="10" cols="50" placeholder="Bạn cần tư vấn loại gạo nào"></textarea>
                    </div>
                </div>
                </div>
              
                <div class="submit"><input type="submit" name="submit" value="Gửi yêu cầu"></div>
            </fieldset>
        </form>
    </section>
    </main>

     <footer class="footer" id="footer-placeholder"></footer>
    <script>
  fetch('header.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('header-placeholder').innerHTML = data;
     
    });
     fetch('footer.php')
    .then(response => response.text())
    .then(data => {
     document.getElementById('footer-placeholder').innerHTML= data;
    });
     
</script>
</body>
</html>