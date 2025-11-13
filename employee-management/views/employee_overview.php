<?php
/**
 * FILE: views/employee_overview.php
 * FUNGSI: Menampilkan ringkasan karyawan dengan COUNT, SUM, dan AVG
 */

include 'views/header.php';
?>

<h2>Ringkasan Karyawan Perusahaan</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Data ringkasan menggunakan fungsi agregat <code>COUNT()</code>, <code>SUM()</code>, dan <code>AVG()</code>.
</p>

<?php if ($overview): ?>
    <!-- Main Statistics -->
    <div class="dashboard-cards">
        <div class="card" style="border-left-color: #667eea;">
            <h3>Total Karyawan</h3>
            <div class="number" style="color: #667eea;"><?php echo $overview['total_employees']; ?></div>
            <p style="margin-top: 0.5rem; color: #666; font-size: 0.9rem;">
                Karyawan aktif di perusahaan
            </p>
        </div>
        
        <div class="card" style="border-left-color: #e74c3c;">
            <h3>Total Gaji per Bulan</h3>
            <div class="number" style="color: #e74c3c; font-size: 1.5rem;">
                Rp <?php echo number_format($overview['total_monthly_salary'], 0, ',', '.'); ?>
            </div>
            <p style="margin-top: 0.5rem; color: #666; font-size: 0.9rem;">
                Total pengeluaran gaji bulanan
            </p>
        </div>
        
        <div class="card" style="border-left-color: #27ae60;">
            <h3>Rata-rata Gaji</h3>
            <div class="number" style="color: #27ae60; font-size: 1.5rem;">
                Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?>
            </div>
            <p style="margin-top: 0.5rem; color: #666; font-size: 0.9rem;">
                Gaji rata-rata per karyawan
            </p>
        </div>
        
        <div class="card" style="border-left-color: #f39c12;">
            <h3>Rata-rata Masa Kerja</h3>
            <div class="number" style="color: #f39c12;">
                <?php echo number_format($overview['avg_years_service'], 1); ?> tahun
            </div>
            <p style="margin-top: 0.5rem; color: #666; font-size: 0.9rem;">
                Pengalaman rata-rata karyawan
            </p>
        </div>
    </div>

    <!-- Proyeksi Annual -->
    <h3 style="margin-top: 3rem;">Proyeksi Pengeluaran Tahunan</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h4 style="margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Total Gaji Tahunan</h4>
            <div style="font-size: 1.8rem; font-weight: bold;">
                Rp <?php echo number_format($overview['total_monthly_salary'] * 12, 0, ',', '.'); ?>
            </div>
            <p style="margin-top: 0.5rem; font-size: 0.85rem; opacity: 0.8;">
                12 bulan × Rp <?php echo number_format($overview['total_monthly_salary'], 0, ',', '.'); ?>
            </p>
        </div>

        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h4 style="margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Bonus Tahunan (1 bulan)</h4>
            <div style="font-size: 1.8rem; font-weight: bold;">
                Rp <?php echo number_format($overview['total_monthly_salary'], 0, ',', '.'); ?>
            </div>
            <p style="margin-top: 0.5rem; font-size: 0.85rem; opacity: 0.8;">
                Estimasi bonus 1× gaji bulanan
            </p>
        </div>

        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h4 style="margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">THR (1 bulan)</h4>
            <div style="font-size: 1.8rem; font-weight: bold;">
                Rp <?php echo number_format($overview['total_monthly_salary'], 0, ',', '.'); ?>
            </div>
            <p style="margin-top: 0.5rem; font-size: 0.85rem; opacity: 0.8;">
                Tunjangan Hari Raya
            </p>
        </div>

        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h4 style="margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Total + Tunjangan</h4>
            <div style="font-size: 1.8rem; font-weight: bold;">
                Rp <?php echo number_format($overview['total_monthly_salary'] * 14, 0, ',', '.'); ?>
            </div>
            <p style="margin-top: 0.5rem; font-size: 0.85rem; opacity: 0.8;">
                Gaji 12 bulan + Bonus + THR
            </p>
        </div>
    </div>

    <!-- Breakdown per Employee -->
    <h3 style="margin-top: 3rem;">Rata-rata per Karyawan</h3>
    <div style="background: white; padding: 2rem; border-radius: 8px; border-left: 4px solid #667eea; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 0.75rem; border-bottom: 1px solid #eee;">
                    <strong>Gaji Bulanan</strong>
                </td>
                <td style="padding: 0.75rem; border-bottom: 1px solid #eee; text-align: right;">
                    <strong>Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?></strong>
                </td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; border-bottom: 1px solid #eee;">
                    Gaji Tahunan (12 bulan)
                </td>
                <td style="padding: 0.75rem; border-bottom: 1px solid #eee; text-align: right;">
                    Rp <?php echo number_format($overview['avg_salary'] * 12, 0, ',', '.'); ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; border-bottom: 1px solid #eee;">
                    Bonus Tahunan (1 bulan)
                </td>
                <td style="padding: 0.75rem; border-bottom: 1px solid #eee; text-align: right;">
                    Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; border-bottom: 1px solid #eee;">
                    THR (1 bulan)
                </td>
                <td style="padding: 0.75rem; border-bottom: 1px solid #eee; text-align: right;">
                    Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?>
                </td>
            </tr>
            <tr style="background: #f8f9fa;">
                <td style="padding: 0.75rem;">
                    <strong>Total per Tahun</strong>
                </td>
                <td style="padding: 0.75rem; text-align: right;">
                    <strong style="color: #667eea; font-size: 1.2rem;">
                        Rp <?php echo number_format($overview['avg_salary'] * 14, 0, ',', '.'); ?>
                    </strong>
                </td>
            </tr>
        </table>
    </div>

    <!-- Additional Insights -->
    <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
        <div style="background: #fff3cd; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #ffc107;">
            <h4 style="color: #856404; margin-bottom: 0.5rem;">💡 Insight Budget</h4>
            <p style="color: #856404; margin: 0;">
                Dengan <?php echo $overview['total_employees']; ?> karyawan, perusahaan memerlukan budget 
                <strong>Rp <?php echo number_format($overview['total_monthly_salary'] * 14, 0, ',', '.'); ?></strong> 
                per tahun untuk gaji, bonus, dan THR.
            </p>
        </div>

        <div style="background: #d1ecf1; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #17a2b8;">
            <h4 style="color: #0c5460; margin-bottom: 0.5rem;">📊 Retensi Karyawan</h4>
            <p style="color: #0c5460; margin: 0;">
                Rata-rata masa kerja <strong><?php echo number_format($overview['avg_years_service'], 1); ?> tahun</strong> 
                menunjukkan tingkat retensi karyawan yang 
                <?php echo $overview['avg_years_service'] >= 3 ? '<strong>baik</strong>' : 'perlu <strong>ditingkatkan</strong>'; ?>.
            </p>
        </div>

        <div style="background: #d4edda; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #28a745;">
            <h4 style="color: #155724; margin-bottom: 0.5rem;">💰 Budget per Karyawan</h4>
            <p style="color: #155724; margin: 0;">
                Budget bulanan per karyawan rata-rata 
                <strong>Rp <?php echo number_format($overview['avg_salary'], 0, ',', '.'); ?></strong>
                atau sekitar <strong>Rp <?php echo number_format($overview['avg_salary'] * 14, 0, ',', '.'); ?></strong> per tahun.
            </p>
        </div>
    </div>

<?php else: ?>
    <div class="alert alert-error">
        <p>Tidak ada data karyawan yang tersedia.</p>
    </div>
<?php endif; ?>

<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px;">
    <strong>Fungsi Agregat yang Digunakan:</strong>
    <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
        <li><code>COUNT(*)</code> - Menghitung total jumlah karyawan</li>
        <li><code>SUM(salary)</code> - Menjumlahkan total gaji semua karyawan</li>
        <li><code>AVG(salary)</code> - Menghitung rata-rata gaji karyawan</li>
        <li><code>AVG(EXTRACT(...))</code> - Menghitung rata-rata masa kerja dalam tahun</li>
    </ul>
</div>

<?php include 'views/footer.php'; ?>