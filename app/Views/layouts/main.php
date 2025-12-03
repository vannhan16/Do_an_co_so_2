<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Drinky - Thỏa cơn khát của bạn</title>

    <link rel="stylesheet" href="public/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined..." rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec5b", // Màu xanh đặc trưng của bạn
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                    }
                },
            },
        }
    </script>
</head>

<body class="bg-background-light dark:bg-background-dark text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">

    <?php include __DIR__ . '/header.php'; ?>

    <div class="flex-1 flex justify-center py-5 sm:px-10 md:px-20 lg:px-40">
        <div class="w-full max-w-6xl">
            <?php
            if (isset($content)) {
                echo $content;
            } else {
                // Mặc định load trang menu nếu chưa set content
                include dirname(__DIR__) . '/client/menu.php';
            }
            ?>
        </div>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>
    <?php include __DIR__ . '/cart_drawer.php'; ?>
    <?php include __DIR__ . '/product_modal.php'; ?>

    <script src="public/assets/js/main.js"></script>
    <script src="public/assets/js/cart.js"></script>
    <script src="public/assets/js/product_modal.js"></script>

</body>

</html>