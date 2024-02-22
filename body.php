<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="">Question-Answer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse container-fluid" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </div>
                <div class="navbar-nav">
                    <div class="mr-1">
                        <?php include './views/login.model.php'; ?>
                    </div>
                    <?php include './views/signup.model.php'; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex gap-3">
            <div class="col-8 border border-primary rounded p-3">
                <div class="mb-3 bg-white rounded p-3">
                    <p class="fs-5 fw-bold mb-1">Name</p>
                    <p class="fs-6 ">How to answer "How are you" just like a Native speaker?
                        Other than "I am fine, Thank you" , How can I answer "How are you" in different way?
                        It is very difficult for me to answer "How are you" when I met some people who come from other
                        countries.</p>
                </div>
                <div class="mb-3 bg-white rounded p-3">
                    <p class="fs-4 fw-bold mb-1">Answer · 6</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend d-flex align-items-center">
                            <img class="rounded-circle" style="width: 30px; height: 30px;"
                                src="https://bloganchoi.com/wp-content/uploads/2022/02/avatar-trang-y-nghia.jpeg"
                                alt="">
                        </div>
                        <input type="text" class="form-control m-2" placeholder="Answer " aria-label="Username"
                            aria-describedby="basic-addon1">
                    </div>
                    <div class="mb-3">
                        <div class="input-group-prepend d-flex align-items-center">
                            <img class="rounded-circle" style="width: 30px; height: 30px;"
                                src="https://bloganchoi.com/wp-content/uploads/2022/02/avatar-trang-y-nghia.jpeg"
                                alt="">
                            <p class="fs-5 fw-bold m-2">Name</p>
                        </div>
                        <p style="margin-left: 40px">
                            In America you can say, "Not bad. How 'bout you?". Or, if you really want to sound like a
                            native speaker you could also respond with, "It's going. And you?". Other ways to respond
                            among close friends is, "I am hanging in there" if you are having an off day etc, or you can
                            be really short with "Good. You?". In America it's just a courteous exchange. Generally, to
                            be polite you would ask someone the typical "Hi! How are you?" but if you wanted to
                            demonstrate a more genuine care you would
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-4 border border-secondary ">
                <div class="bg-white rounded p-4 d-flex flex-column">
                    <div class="input-group-prepend d-flex flex-column justify-content-center align-items-center">
                        <img class="rounded-circle" style="width: 150px; height: 150px;"
                            src="https://bloganchoi.com/wp-content/uploads/2022/02/avatar-trang-y-nghia.jpeg" alt="">
                        <p class="fs-5 fw-bold m-2">Name</p>
                    </div>

                    <button type="button" class="btn btn-warning">Follow</button>
                </div>

            </div>
        </div>
    </div>
</div>