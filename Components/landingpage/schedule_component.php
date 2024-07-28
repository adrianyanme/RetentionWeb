<!-- <div class="row mx-3 mt-10 justify-content-center" id="schedulecomponent">
    <div class="col-12 col-lg-6 d-flex flex-column align-items-center">
        <div class="p-2 text-center">
            <p class="fw-medium fs-3 text-primary text-white">Jadwal Sidang Hari ini!</p>
            <h1 class="fw-bolder display-3 text-primary text-white">Mau lihat? Cek di Streaming ya</h1>
            <div class="bg-warning my-4" style="height: 2px; max-width: 200px; margin: 0 auto;"></div>
        </div>
    </div>
    <div class="col-12 col-lg-6 d-flex flex-column align-items-center">
        <div class="card mb-5 mx-auto"  max-width: 80%;">
            <div class="card-header text-center" style="background-color: #010314; color: #C4DFE6;">Jadwal</div>
            <div class="card-block p-0">
                <table class="table table-bordered table-sm m-0" style="background-color: #010314;color: #C4DFE6;">
                    <thead class="">
                        <tr>
                            <th>Hearing Number</th>
                            <th>Agenda</th>
                            <th>Hearing Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($paginated_data) : ?>
                            <?php foreach ($paginated_data as $schedule) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($schedule['hearing_number']); ?></td>
                                    <td><?php echo htmlspecialchars($schedule['agenda']); ?></td>
                                    <td><?php echo htmlspecialchars(date('H:i d-m-Y', strtotime($schedule['hearing_time']))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3"><?php echo htmlspecialchars($schedules_error_message ?? 'No schedules available.'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer p-0" style="background-color: #010314; color: #C4DFE6;">
                <nav aria-label="...">
                    <ul class="pagination justify-content-end mt-3 mr-3">
                        <li class="page-item <?php if ($current_page <= 1) echo 'disabled'; ?>">
                            <a class="page-link" href="?page=<?php echo $current_page - 1; ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php if ($current_page >= $total_pages) echo 'disabled'; ?>">
                            <a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div> -->