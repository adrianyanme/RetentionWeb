<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .contact-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
        }
        .comment-section {
            margin-bottom: 30px;
        }
        .comment {
            margin-bottom: 20px;
        }
        .comment img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .comment .comment-body {
            margin-left: 70px;
        }
        .comment .comment-body h5 {
            margin: 0;
        }
        .comment .comment-body p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="comment-section">
                    <div class="comment d-flex">
                        <img src="https://via.placeholder.com/50" alt="Anna Smith">
                        <div class="comment-body">
                            <h5>Anna Smith</h5>
                            <p>Crass sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                        </div>
                    </div>
                    <div class="comment d-flex">
                        <img src="https://via.placeholder.com/50" alt="Danny Tatum">
                        <div class="comment-body w-100">
                            <h5>Danny Tatum</h5>
                            <textarea class="form-control" placeholder="Write your comment..."></textarea>
                        </div>
                    </div>
                    <div class="comment d-flex">
                        <img src="https://via.placeholder.com/50" alt="Caroline Horwitz">
                        <div class="comment-body">
                            <h5>Caroline Horwitz</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Corporis odit minima eaque dignissimos recusandae officiis commodi nulla est, tempore atque voluptas non quod maxime, iusto, debitis aliquid? Iure ipsum, itaque.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-form">
                    <h4>Contact Us</h4>
                    <form>
                        <div class="form-group">
                            <label for="name">Your name</label>
                            <input type="text" class="form-control" id="name" placeholder="Your name">
                        </div>
                        <div class="form-group">
                            <label for="email">Your email</label>
                            <input type="email" class="form-control" id="email" placeholder="Your email">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <label for="message">Your message</label>
                            <textarea class="form-control" id="message" rows="3" placeholder="Your message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">SEND</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>