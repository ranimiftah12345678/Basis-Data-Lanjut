<?php
/**
 * FILE: views/salary_search.php
 * FUNGSI: Form untuk mencari karyawan berdasarkan rentang gaji & menampilkan hasil
 */

include 'views/header.php';
?>

<h2>Pencarian Karyawan Berdasarkan Gaji</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Gunakan form ini untuk memanggil Fungsi <code>get_employees_by_salary_range()</code> di database PostgreSQL.
</p>

<form method="POST" action="index.php?action=search_salary" class="form-section">
    <div style="display: flex; gap: 1rem; align-items: flex-end;">
        <div class="form-group" style="flex: 1;">
            <label for="min_salary" class="form-label">Gaji Minimum (Rp)</label>
            <input type="number" id="min_salary" name="min_salary" class="form-input" 
                   value="<?php echo isset($min_salary) ? htmlspecialchars($min_salary) : '3000000'; ?>" required>
        </div>
        <div class="form-group" style="flex: 1;">
            <label for="max_salary" class="form-label">Gaji Maksimum (Rp)</label>
            <input type="number" id="max_salary" name="max_salary" class="form-input" 
                   value="<?php echo isset($max_salary) ? htmlspecialchars($max_salary) : '7000000'; ?>" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Cari Karyawan</button>
        </div>
    </div>
</form>

<?php if (isset($results)): // $results hanya ada jika form sudah di-submit ?>
    
    <h3 style="margin-top: 2rem; border-bottom: 2px solid #ddd; padding-bottom: 0.5rem;">
        Hasil Pencarian (<?php echo $results->rowCount(); ?> ditemukan)
    </h3>

    <?php if ($results->rowCount() > 0): ?>
        <table class="data-table" style="margin-top: 1rem;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Departemen</th>
                    <th>Posisi</th>
                    <th>Gaji</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $results->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                        <td><?php echo htmlspecialchars($row['employee_position']); ?></td>
                        <td><strong>Rp <?php echo number_format($row['salary'], 0, ',', '.'); ?></strong></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-error" style="margin-top: 1rem;">
            <p>Tidak ada karyawan yang ditemukan dalam rentang gaji tersebut.</p>
        </div>
    <?php endif; ?>

<?php endif; ?>

<?php
include 'views/footer.php';
?>