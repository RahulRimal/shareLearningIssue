<?php include('includes/header.php');?>


    <main class="my-2">

        <!-- main wide content starts here  -->

        <div class="main-wide-content container-fluid">
            <div class="user-add-post">
                <div class="container">
                    <div class="text-center bg-white p-4 mt-5 rounded">
                        <div class="row add-post-heading mb-4">
                            <div class="col text-center text-md-end p-0">
                                <h3 id="sell-buy-form-title" class="text-center text-md-end">Sell Your Book</h3>
                            </div>
                            <div class="col d-flex justify-content-center justify-content-md-end text-end p-0">
                                <div class="sell-buy-form-buttons-holder d-flex justify-content-around align-items-center">
                                    <div id="sell-form-button" class="sell-buy-button-active text-center" onclick="showHideFormTabs(this)">
                                        Sell Book
                                    </div>
                                    <div id="buy-form-button" class="sell-buy-button-inactive text-center" onclick="showHideFormTabs(this)">
                                        Buy Book
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-post-body">
                            <div class="sell-book-tab">
                                <form id="addOnSaleForm" class="d-block">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control add-post-input" id="sellingBookName"
                                            aria-describedby="emailHelp" placeholder="Enter Book name">
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                                            <input type="text" class="form-control add-post-input"
                                                placeholder="Author Name">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <input type="date" class="form-control add-post-input htmlCalender"
                                                placeholder="Bought Date">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend"
                                                    style="border: 2px solid var(--primary-color);">
                                                    <span class="input-group-text"
                                                        style="background-color: var(--primary-color); color: white">Rs.</span>
                                                </div>
                                                <input type="number" class="form-control add-post-input"
                                                    style="color: green!important;" placeholder="Price of a book"
                                                    aria-label="Amount (to the nearest dollar)">
                                                <div class="input-group-append"
                                                    style="border: 2px solid var(--primary-color);">
                                                    <span class="input-group-text"
                                                        style="background-color: var(--primary-color); color: white">.00</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="col p-0 mb-3">
                                                <input type="number" class="form-control add-post-input"
                                                    placeholder="Quantity">
                                            </div>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                              <input type="file" class="custom-file-input" id="inputGroupFile02">
                                              <!-- <input type="file" name="addPostPics" class="add-post-input"> -->
                                              <label class="custom-file-label add-post-input" for="inputGroupFile02">Choose file</label>
                                            </div>
                                          </div>

                                    </div>

                                    <div class="sell-book-post-pics py-3" style="text-align: -webkit-center;">
                                        <ul style="margin:0;padding:0;list-style:none;" id="sellBookPostPics" class="cs-hidden">
                                            <li class="item-a" style="margin:0;padding:0;list-style:none;"><img src="assets/img/Share Your Learning.png" alt=""></li>
                                            <li class="item-b" style="margin:0;padding:0;list-style:none;"><img src="https://cdn.pixabay.com/photo/2021/07/02/03/19/panpipe-6380762__340.jpg" alt=""></li>
                                            <li class="item-c" style="margin:0;padding:0;list-style:none;"><img src="assets/img/Share Your Learning.png" alt=""></li>
                                            <li class="item-d" style="margin:0;padding:0;list-style:none;"><img src="assets/img/Share Your Learning.png" alt=""></li>
                                        </ul>
                                    </div>

                                    <div class="post-button text-end">
                                        <button type="submit" class="btn btn-primary col-12 col-md-2 p-0 text-center w-100 w-md-25 font-weight-bold">Post</button>
                                    </div>
                                </form>
                            </div>
                            <div class="buy-book-tab">
                                <form id="addBuyingForm" class="d-none">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control add-post-input" id="sellingBookName"
                                            aria-describedby="emailHelp" placeholder="Enter Book name">
                                    </div>
                                    
                                        <input type="text" class="form-control add-post-input"
                                            placeholder="Author Name">
                                    

                                    <div class="row mt-3">
                                        <div class="col-12 col-md-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend"
                                                    style="border: 2px solid var(--primary-color);">
                                                    <span class="input-group-text"
                                                        style="background-color: var(--primary-color); color: white">Rs.</span>
                                                </div>
                                                <input type="number" class="form-control add-post-input"
                                                    style="color: green!important;" placeholder="Price of a book"
                                                    aria-label="Amount (to the nearest dollar)">
                                                <div class="input-group-append"
                                                    style="border: 2px solid var(--primary-color);">
                                                    <span class="input-group-text"
                                                        style="background-color: var(--primary-color); color: white">.00</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="col p-0 mb-3">
                                                <input type="number" class="form-control add-post-input"
                                                    placeholder="Quantity">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="post-button text-end">
                                        <button type="submit" class="btn btn-primary col-12 col-md-2 p-0 text-center w-100 w-md-25 font-weight-bold">Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="add-post-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- main wide content ends here  -->

        <!-- main narrow content starts here  -->

        <div class="main-content container">

            <!-- Left sidebar starts here  -->
            <div class="left-sidebar">

            </div>

            <!-- Left sidebar ends here  -->

            <!-- main center content starts here  -->

            <div class="main-center-content me-auto col-lg-6">

            </div>

            <!-- main center content ends here  -->


            <!-- Right sidebar starts here  -->

            <div class="right-sidebar col-lg-3">

            </div>

            <!-- Right sidebar ends here  -->

        </div>

        <!-- main narrow content ends here  -->

    </main>



    <!-- Footer starts here -->

    <?php include('includes/footer.php');?>