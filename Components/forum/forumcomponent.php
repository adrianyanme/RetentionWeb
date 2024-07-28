<div class="alert alert-success alert-dismissible fade show" role="alert">
        Selamat datang di halaman forum!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <main class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div class="typewriter">
                    <h1 id="typewriter" class="display-4 text-center" style="color: white;">Forums</h1>
                </div>
                <nav aria-label="breadcrumb">
                </nav>
                <div class="input-group mb-3">
                    <input type="text" id="search-input" class="form-control" placeholder="Type to search" aria-label="Search">
                    <button class="btn btn-outline-secondary" id="search-button" type="button"><i class="fa fa-search"></i></button>
                </div>
                <?php if ($user): ?>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#postForumModal">Post Forum</button>
                <?php endif; ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Forum</th>
                            <th scope="col">Tag</th>
                            <th scope="col">Comments</th>
                            <th scope="col">Freshness</th>
                        </tr>
                    </thead>
                    <tbody id="forum-table-body">
                        <?php foreach ($data['data'] as $forum): ?>
                        <tr>
                            <td>
                                <h5><a href="forum_detail.php?id=<?= $forum['id'] ?>"><?= $forum['title'] ?></a></h5>
                                <p><?= $forum['content'] ?></p>
                                <div>
                                    <span><?= $forum['likes_count'] ?> likes</span> | <span><?= $forum['dislikes_count'] ?> dislikes</span>
                                </div>
                            </td>
                            <td><?= $forum['tags'] ?></td>
                            <td><?= $forum['comment_total'] ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= $forum['image'] ?>" class="rounded-circle me-2" alt="User">
                                    <div>
                                        <strong><?= $forum['writer']['username'] ?></strong><br>
                                        <small><?= $forum['created_at'] ?></small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="modal fade" id="postForumModal" tabindex="-1" aria-labelledby="postForumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postForumModalLabel">Post Forum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form id="postForumForm" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags" required>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Typewriter effect for "Retention"
            const loopElement = document.getElementById("typewriter-loop");
            const loopText = loopElement.textContent;
            loopElement.textContent = "";

            let loopIndex = 0;
            let isDeleting = false;

            function loopTypeWriter() {
                if (isDeleting) {
                    if (loopIndex > 0) {
                        loopElement.textContent = loopText.substring(0, loopIndex - 1);
                        loopIndex--;
                        setTimeout(loopTypeWriter, 50); // Adjust deleting speed here
                    } else {
                        isDeleting = false;
                        setTimeout(loopTypeWriter, 500); // Pause before typing again
                    }
                } else {
                    if (loopIndex < loopText.length) {
                        loopElement.textContent += loopText.charAt(loopIndex);
                        loopIndex++;
                        setTimeout(loopTypeWriter, 100); // Adjust typing speed here
                    } else {
                        isDeleting = true;
                        setTimeout(loopTypeWriter, 1000); // Pause before deleting
                    }
                }
            }

            loopTypeWriter();

            // Typewriter effect for "Forums"
            const forumsElement = document.getElementById("typewriter-forums");
            const forumsText = forumsElement.textContent;
            forumsElement.textContent = "";

            let forumsIndex = 0;
            let forumsIsDeleting = false;

            function forumsTypeWriter() {
                if (forumsIsDeleting) {
                    if (forumsIndex > 0) {
                        forumsElement.textContent = forumsText.substring(0, forumsIndex - 1);
                        forumsIndex--;
                        setTimeout(forumsTypeWriter, 50); // Adjust deleting speed here
                    } else {
                        forumsIsDeleting = false;
                        setTimeout(forumsTypeWriter, 500); // Pause before typing again
                    }
                } else {
                    if (forumsIndex < forumsText.length) {
                        forumsElement.textContent += forumsText.charAt(forumsIndex);
                        forumsIndex++;
                        setTimeout(forumsTypeWriter, 100); // Adjust typing speed here
                    } else {
                        forumsIsDeleting = true;
                        setTimeout(forumsTypeWriter, 1000); // Pause before deleting
                    }
                }
            }

            forumsTypeWriter();
        });
    </script>

    <style>
        .typewriter p, .typewriter h1 {
            overflow: hidden; /* Ensures the content is not revealed until the animation */
            border-right: .15em solid orange; /* The typewriter cursor */
            white-space: nowrap; /* Keeps the content on a single line */
            margin: 0 auto; /* Gives that scrolling effect as the typing happens */
            letter-spacing: .15em; /* Adjust as needed */
        }

        .typing {
            animation: blink-caret .75s step-end infinite;
        }

        /* The typewriter cursor effect */
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: orange; }
        }
    </style>