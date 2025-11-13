<?php
/**
 * FILE: views/salary_stats.php
 * FUNGSI: Menampilkan statistik gaji dengan fungsi agregat PostgreSQL
 */

include 'views/header.php';
?>

<h2>Statistik Gaji per Departemen</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Data statistik gaji menggunakan fungsi agregat <code>AVG()</code>, <code>MAX()</code>, <code>MIN()</code>, dan <code>GROUP BY</code>.
</p>

<?php if ($salaryStats->rowCount() > 0): ?>
    <?php
    $all_stats = $salaryStats->fetchAll(PDO::FETCH_ASSOC);
    $grand_total_employees = array_sum(array_column($all_stats, 'employee_count'));
    $grand_avg_salary = array_sum(array_column($all_stats, 'avg_salary')) / count($all_stats);
    $grand_max_salary = max(array_column($all_stats, 'max_salary'));
    $grand_min_salary = min(array_column($all_stats, 'min_salary'));
    ?>

    <!-- Summary Cards -->
    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Departemen</h3>
            <div class="number"><?php echo count($all_stats); ?></div>
        </div>
        <div class="card">
            <h3>Rata-rata Gaji Keseluruhan</h3>
            <div class="number">Rp <?php echo number_format($grand_avg_salary, 0, ',', '.'); ?></div>
        </div>
        <div class="card">
            <h3>Gaji Tertinggi</h3>
            <div class="number">Rp <?php echo number_format($grand_max_salary, 0, ',', '.'); ?></div>
        </div>
        <div class="card">
            <h3>Gaji Terendah</h3>
            <div class="number">Rp <?php echo number_format($grand_min_salary, 0, ',', '.'); ?></div>
        </div>
    </div>

    <!-- Tabel Detail -->
    <table class="data-table">
        <thead>
            <tr>
                <th>Departemen</th>
                <th>Jumlah Karyawan</th>
                <th>Rata-rata Gaji</th>
                <th>Gaji Tertinggi</th>
                <th>Gaji Terendah</th>
                <th>Selisih (Max-Min)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_stats as $stat): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($stat['department']); ?></strong></td>
                    <td style="text-align: center;">
                        <span style="padding: 0.25rem 0.75rem; background: #667eea; color: white; border-radius: 20px;">
                            <?php echo $stat['employee_count']; ?>
                        </span>
                    </td>
                    <td><strong>Rp <?php echo number_format($stat['avg_salary'], 0, ',', '.'); ?></strong></td>
                    <td style="color: #27ae60;"><strong>Rp <?php echo number_format($stat['max_salary'], 0, ',', '.'); ?></strong></td>
                    <td style="color: #e74c3c;">Rp <?php echo number_format($stat['min_salary'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($stat['max_salary'] - $stat['min_salary'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Visualisasi Chart -->
    <div style="margin-top: 3rem;">
        <h3>Visualisasi Perbandingan Gaji</h3>
        
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #667eea;">
            <h4>Perbandingan Gaji per Departemen</h4>
            <?php foreach ($all_stats as $stat): ?>
                <div style="margin: 1rem 0;">
                    <div style="margin-bottom: 0.5rem;">
                        <strong><?php echo htmlspecialchars($stat['department']); ?></strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                        <span style="width: 100px; font-size: 0.85rem;">Min:</span>
                        <div style="flex: 1; background: #f0f0f0; border-radius: 4px; height: 15px;">
                            <div style="background: #e74c3c; height: 100%; border-radius: 4px; width: <?php echo ($stat['min_salary'] / $grand_max_salary) * 100; ?>%;"></div>
                        </div>
                        <span style="width: 150px; text-align: right; font-size: 0.85rem;">Rp <?php echo number_format($stat['min_salary'], 0, ',', '.'); ?></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                        <span style="width: 100px; font-size: 0.85rem;">Rata-rata:</span>
                        <div style="flex: 1; background: #f0f0f0; border-radius: 4px; height: 20px;">
                            <div style="background: #667eea; height: 100%; border-radius: 4px; width: <?php echo ($stat['avg_salary'] / $grand_max_salary) * 100; ?>%;"></div>
                        </div>
                        <span style="width: 150px; text-align: right; font-size: 0.85rem;"><strong>Rp <?php echo number_format($stat['avg_salary'], 0, ',', '.'); ?></strong></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="width: 100px; font-size: 0.85rem;">Max:</span>
                        <div style="flex: 1; background: #f0f0f0; border-radius: 4px; height: 15px;">
                            <div style="background: #27ae60; height: 100%; border-radius: 4px; width: <?php echo ($stat['max_salary'] / $grand_max_salary) * 100; ?>%;"></div>
                        </div>
                        <span style="width: 150px; text-align: right; font-size: 0.85rem;">Rp <?php echo number_format($stat['max_salary'], 0, ',', '.'); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php else: ?>
    <div class="alert alert-error">
        <p>Tidak ada data statistik gaji.</p>
    </div>
<?php endif; ?>

<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px;">
    <strong>Fungsi Agregat yang Digunakan:</strong>
    <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
        <li><code>AVG(salary)</code> - Menghitung rata-rata gaji</li>
        <li><code>MAX(salary)</code> - Mencari gaji tertinggi</li>
        <li><code>MIN(salary)</code> - Mencari gaji terendah</li>
        <li><code>GROUP BY department</code> - Mengelompokkan berdasarkan departemen</li>
    </ul>
</div>

<?php include 'views/footer.php'; ?>