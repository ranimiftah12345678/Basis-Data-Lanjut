<?php
/**
 * FILE: views/tenure_stats.php
 * FUNGSI: Menampilkan statistik masa kerja karyawan dengan CASE WHEN dan GROUP BY
 */

include 'views/header.php';
?>

<h2>Statistik Masa Kerja Karyawan</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Data masa kerja menggunakan fungsi <code>COUNT()</code>, <code>CASE WHEN</code>, dan <code>GROUP BY</code>.
    <br>Kategori: <strong>Junior</strong> (&lt;1 tahun), <strong>Middle</strong> (1-3 tahun), <strong>Senior</strong> (&gt;3 tahun)
</p>

<?php if ($tenureStats->rowCount() > 0): ?>
    <?php
    $all_employees = $tenureStats->fetchAll(PDO::FETCH_ASSOC);
    
    // Hitung statistik per kategori
    $junior_count = count(array_filter($all_employees, fn($e) => $e['tenure_category'] == 'Junior'));
    $middle_count = count(array_filter($all_employees, fn($e) => $e['tenure_category'] == 'Middle'));
    $senior_count = count(array_filter($all_employees, fn($e) => $e['tenure_category'] == 'Senior'));
    $total_count = count($all_employees);
    ?>

    <!-- Summary Cards -->
    <div class="dashboard-cards">
        <div class="card" style="border-left-color: #3498db;">
            <h3>Junior (&lt;1 tahun)</h3>
            <div class="number" style="color: #3498db;"><?php echo $junior_count; ?></div>
            <p style="margin-top: 0.5rem; color: #666;">
                <?php echo $total_count > 0 ? number_format(($junior_count/$total_count)*100, 1) : 0; ?>% dari total
            </p>
        </div>
        <div class="card" style="border-left-color: #f39c12;">
            <h3>Middle (1-3 tahun)</h3>
            <div class="number" style="color: #f39c12;"><?php echo $middle_count; ?></div>
            <p style="margin-top: 0.5rem; color: #666;">
                <?php echo $total_count > 0 ? number_format(($middle_count/$total_count)*100, 1) : 0; ?>% dari total
            </p>
        </div>
        <div class="card" style="border-left-color: #27ae60;">
            <h3>Senior (&gt;3 tahun)</h3>
            <div class="number" style="color: #27ae60;"><?php echo $senior_count; ?></div>
            <p style="margin-top: 0.5rem; color: #666;">
                <?php echo $total_count > 0 ? number_format(($senior_count/$total_count)*100, 1) : 0; ?>% dari total
            </p>
        </div>
        <div class="card">
            <h3>Total Karyawan</h3>
            <div class="number"><?php echo $total_count; ?></div>
        </div>
    </div>

    <!-- Tabel Detail Karyawan -->
    <h3 style="margin-top: 2rem;">Detail Karyawan Berdasarkan Masa Kerja</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Departemen</th>
                <th>Tanggal Bergabung</th>
                <th>Lama Bekerja</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_employees as $emp): ?>
                <?php
                $badge_colors = [
                    'Junior' => ['bg' => '#3498db', 'text' => 'white'],
                    'Middle' => ['bg' => '#f39c12', 'text' => 'white'],
                    'Senior' => ['bg' => '#27ae60', 'text' => 'white']
                ];
                $color = $badge_colors[$emp['tenure_category']];
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($emp['first_name'] . ' ' . $emp['last_name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($emp['department']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($emp['hire_date'])); ?></td>
                    <td><?php echo number_format($emp['years_worked'], 1); ?> tahun</td>
                    <td>
                        <span style="padding: 0.4rem 0.8rem; background: <?php echo $color['bg']; ?>; color: <?php echo $color['text']; ?>; border-radius: 20px; font-weight: bold;">
                            <?php echo $emp['tenure_category']; ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Statistik per Departemen -->
    <?php
    // Group by department
    $dept_stats = [];
    foreach ($all_employees as $emp) {
        $dept = $emp['department'];
        $cat = $emp['tenure_category'];
        if (!isset($dept_stats[$dept])) {
            $dept_stats[$dept] = ['Junior' => 0, 'Middle' => 0, 'Senior' => 0];
        }
        $dept_stats[$dept][$cat]++;
    }
    ?>

    <h3 style="margin-top: 3rem;">Distribusi Masa Kerja per Departemen</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin-top: 1rem;">
        <?php foreach ($dept_stats as $dept => $cats): ?>
            <div style="background: white; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #667eea; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <h4 style="margin-bottom: 1rem; color: #333;"><?php echo htmlspecialchars($dept); ?></h4>
                <div style="margin-top: 1rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: #666;">Junior:</span>
                        <strong style="color: #3498db;"><?php echo $cats['Junior']; ?> orang</strong>
                    </div>
                    <div style="background: #f0f0f0; border-radius: 4px; height: 8px; margin-bottom: 1rem;">
                        <div style="background: #3498db; height: 100%; border-radius: 4px; width: <?php echo (array_sum($cats) > 0) ? ($cats['Junior']/array_sum($cats))*100 : 0; ?>%;"></div>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: #666;">Middle:</span>
                        <strong style="color: #f39c12;"><?php echo $cats['Middle']; ?> orang</strong>
                    </div>
                    <div style="background: #f0f0f0; border-radius: 4px; height: 8px; margin-bottom: 1rem;">
                        <div style="background: #f39c12; height: 100%; border-radius: 4px; width: <?php echo (array_sum($cats) > 0) ? ($cats['Middle']/array_sum($cats))*100 : 0; ?>%;"></div>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: #666;">Senior:</span>
                        <strong style="color: #27ae60;"><?php echo $cats['Senior']; ?> orang</strong>
                    </div>
                    <div style="background: #f0f0f0; border-radius: 4px; height: 8px;">
                        <div style="background: #27ae60; height: 100%; border-radius: 4px; width: <?php echo (array_sum($cats) > 0) ? ($cats['Senior']/array_sum($cats))*100 : 0; ?>%;"></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>
    <div class="alert alert-error">
        <p>Tidak ada data karyawan.</p>
    </div>
<?php endif; ?>

<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px;">
    <strong>Fungsi yang Digunakan:</strong>
    <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
        <li><code>COUNT(*)</code> - Menghitung jumlah karyawan per kategori</li>
        <li><code>CASE WHEN ... THEN ... END</code> - Kategorisasi berdasarkan lama bekerja</li>
        <li><code>GROUP BY</code> - Mengelompokkan data berdasarkan departemen dan kategori</li>
        <li><code>EXTRACT(YEAR FROM AGE(...))</code> - Menghitung lama bekerja dalam tahun</li>
    </ul>
</div>

<?php include 'views/footer.php'; ?>