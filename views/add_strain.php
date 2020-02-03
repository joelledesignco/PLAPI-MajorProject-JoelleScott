<?php  require_once("../core/includes.php");
    // unique html head vars
    $title = 'Home Page';
    require_once("../elements/html_head.php");
    require_once("../elements/nav.php");

?>
<section id="add-bg">
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto blurry-bg2 p-5 mt-5 shadow-lg">
                <h3 class="text-center">Add New Strain</h3>
                <div class="my-hr mx-auto"></div>
                <form action="/projects/add.php" method="post" enctype="multipart/form-data">
                    <img id="img-preview">
                    <div class="form-group">
                        <input id="file-with-preview" type="file" name="fileToUpload" onchange="previewFile()" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input class="form-control" type="text" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input class="form-control" type="text" name="category" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>
                    <input class="my-button mx-auto mt-5" type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

<?php require_once("../elements/footer.php");?>
</section>

