<?php include 'fetch_data.php'; ?>

<?php
// Mengambil data dari API
$api_url = 'http://143.198.218.9:8000/api/forums';
$response = file_get_contents($api_url);
$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retention</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&display=swap" media="all">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Slab', monospace;
            background-color: #263238;
        }
        .header {
            background-image: url('assets/img/header.jpeg'); /* Ganti dengan path gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
            padding: 60px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }
        .search-bar {
            max-width: 600px;
            margin: 0 auto;
        }
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin: 20px 0;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: white;
        }
        .breadcrumb-item a {
            color: white;
            text-decoration: none;
        }
        .breadcrumb-item.active {
            color: white;
        }
        .update-info {
            text-align: right;
            color: white;
            margin-right: 20px;
        }
        .ask-question {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 5rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .ask-question img {
            max-width: 50px;
            margin-right: 20px;
        }
        .ask-question .content {
            flex-grow: 1;
        }
        .ask-question .btn {
            background-color: #1E88E5;
            color: white;
        }
        .question-list {
            margin-top: 2rem;
            background-color: #263238; /* Warna background yang lebih gelap */
            padding: 20px;
            border-radius: 10px;
        }
        .question-item {
            background-color: #37474F; /* Warna background item pertanyaan */
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        .question-item img {
            max-width: 50px;
            margin-right: 20px;
            border-radius: 50%;
        }
        .question-item .content {
            flex-grow: 1;
        }
        .question-item .tags {
            margin-top: 10px;
        }
        .question-item .tags .badge {
            margin-right: 5px;
        }
        .question-item .stats {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .question-item .stats .stat {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }
        .question-item .stats .stat i {
            margin-right: 5px;
        }
        .question-item .time {
            text-align: right;
            color: gray;
        }
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }
        .modal-content {
            background-color: #37474F;
            color: white;
        }
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            .header p {
                font-size: 1rem;
            }
            .ask-question {
                flex-direction: column;
                text-align: center;
            }
            .ask-question img {
                margin-bottom: 10px;
            }
            .question-item {
                flex-direction: column;
                text-align: center;
            }
            .question-item img {
                margin-bottom: 10px;
            }
            .question-item .time {
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var data = <?= json_encode($data['data']) ?>;

            function renderQuestions(questions) {
                var questionList = $('.question-list');
                questionList.empty();
                questions.forEach(function(question) {
                    var questionItem = `
                        <div class="question-item" data-id="${question.id}">
                            <img src="http://127.0.0.1:8000/storage/profileimg${question.writer.profileimg}" alt="User Image">
                            <div class="content">
                                <h5>${question.title}</h5>
                                <div class="stats">
                                    <div class="stat"><i class="fa fa-comment"></i> ${question.comment_total} Answers</div>
                                    <div class="stat"><i class="fa fa-arrow-up"></i> ${question.likes_count} Votes</div>
                                    <div class="stat"><i class="fa fa-arrow-down"></i> ${question.dislikes_count} Votes</div>
                                </div>
                                <div class="tags">
                                    <span class="badge bg-secondary">${question.tags}</span>
                                </div>
                            </div>
                            <div class="time">Asked ${question.created_at}</div>
                        </div>
                    `;
                    questionList.append(questionItem);
                });
            }

            renderQuestions(data);

            $('#search-button').click(function() {
                var searchQuery = $('#search-input').val().toLowerCase();
                var filteredData = data.filter(function(item) {
                    return item.title.toLowerCase().includes(searchQuery) || item.content.toLowerCase().includes(searchQuery);
                });
                renderQuestions(filteredData);
            });

            $(document).on('click', '.question-item', function() {
                var questionId = $(this).data('id');
                window.location.href = 'newforum_detail.php?id=' + questionId;
            });

            // Show modal on button click
            $('#ask-question-button').click(function() {
                $('#askQuestionModal').modal('show');
            });

            // Handle form submission
            $('#ask-question-form').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/forums',
                    type: 'POST',
                    headers: {
                        'Authorization': 'Bearer <?= $_SESSION['token'] ?>'
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('Question submitted successfully!');
                        $('#askQuestionModal').modal('hide');
                        // Optionally, you can refresh the question list or redirect the user
                    },
                    error: function() {
                        alert('Error submitting question');
                    }
                });
            });
        });
    </script>
</head>

<body>
<?php include 'Components/main/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header">
                    <h1>Forum</h1>
                    <p>Diskusi And Sharing</p>
                    <div class="search-bar">
                        <div class="input-group">
                            <input type="text" id="search-input" class="form-control" placeholder="Cari..">
                            <button class="btn btn-primary" id="search-button" type="button">Search</button>
                        </div>
                    </div>
                </div>
                <div class="ask-question bg-dark">
                    <img src="https://static.vecteezy.com/system/resources/previews/007/117/340/non_2x/concept-illustration-of-people-frequently-asked-questions-around-question-marks-answer-to-question-metaphor-flat-modern-design-illustration-vector.jpg" alt="Illustration"> <!-- Ganti dengan path gambar ilustrasi Anda -->
                    <div class="content">
                        <h5 class="text-warning" >Can't find an answer?</h5>
                        <p class="text-white">Make use of a qualified tutor to get the answer</p>
                    </div>
                    <button class="btn btn-primary" id="ask-question-button">Ask a Question</button>
                </div>
                <div class="question-list">
                    <!-- Question items will be appended here by jQuery -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="askQuestionModal" tabindex="-1" aria-labelledby="askQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="askQuestionModalLabel">Ask a Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ask-question-form">
                        <div class="mb-3">
                            <label for="question-title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="question-title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="question-content" class="form-label">Content</label>
                            <textarea class="form-control" id="question-content" name="content" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="question-tags" class="form-label">Tags</label>
                            <input type="text" class="form-control" id="question-tags" name="tags" required>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Image (Optional)</label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'Components/main/footer.php'; ?>

</html>