<?php
/**
 * FILE: index.php - Main Controller
 * FUNGSI: Controller utama yang menangani semua request
 */

// Include file yang diperlukan
require_once 'config/database.php';
require_once 'models/EmployeeModel.php';

// Inisialisasi database dan model
$database = new Database();
$db = $database->getConnection();
$employeeModel = new EmployeeModel($db);

// Tangani action dari URL
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

switch ($action) {
    case 'dashboard':
        $dashboard = $employeeModel->getDashboardSummary();
        include 'views/dashboard.php';
        break;

    case 'list':
        $employees = $employeeModel->getAllEmployees();
        include 'views/employee_list.php';
        break;

    case 'create':
        if ($_POST) {
            // Proses form submission
            $data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'department' => $_POST['department'],
                'position' => $_POST['position'],
                'salary' => str_replace('.', '', $_POST['salary']), // Hapus titik dari salary
                'hire_date' => $_POST['hire_date'],
            ];

            if ($employeeModel->createEmployee($data)) {
                header("Location: index.php?action=list&message=created");
            } else {
                $error = "Gagal menambah karyawan.";
            }
        }
        include 'views/employee_form.php';
        break;

    case 'edit':
        $id = $_GET['id'];
        if ($_POST) {
            $data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'department' => $_POST['department'],
                'position' => $_POST['position'],
                'salary' => str_replace('.', '', $_POST['salary']), // Hapus titik dari salary
                'hire_date' => $_POST['hire_date'],
            ];

            if ($employeeModel->updateEmployee($id, $data)) {
                header("Location: index.php?action=list&message=updated");
            } else {
                $error = "Gagal mengupdate karyawan.";
            }
        }
        $employee = $employeeModel->getEmployeeById($id);
        include 'views/employee_form.php';
        break;

    case 'delete':
        $id = $_GET['id'];
        if ($employeeModel->deleteEmployee($id)) {
            header("Location: index.php?action=list&message=deleted");
        } else {
            header("Location: index.php?action=list&message=delete_error");
        }
        break;

    case 'department_stats':
        $stats = $employeeModel->getDepartmentStats();
        include 'views/department_stats.php';
        break;
        // TUGAS 1.1: Halaman Statistik Gaji
    case 'salary_stats':
        $salaryStats = $employeeModel->getSalaryStats();
        include 'views/salary_stats.php';
        break;

    // TUGAS 1.2: Halaman Masa Kerja
    case 'tenure_stats':
        $tenureStats = $employeeModel->getTenureStats();
        include 'views/tenure_stats.php';
        break;

    // TUGAS 1.3: Halaman Ringkasan Karyawan
    case 'employee_overview':
        $overview = $employeeModel->getEmployeeOverview();
        include 'views/employee_overview.php';
        break;

    // TUGAS FUNCTION: Halaman Pencarian Gaji
    case 'search_salary':
        // Cek apakah form di-submit
        if ($_POST) {
            // Ambil data dari form
            $min_salary = $_POST['min_salary'];
            $max_salary = $_POST['max_salary'];
            
            // Panggil method baru di model (Langkah 2)
            $results = $employeeModel->getEmployeesBySalary($min_salary, $max_salary);
        }
        
        // Load view (Langkah 3). 
        // Jika $results ada, view akan menampilkannya.
        // Jika tidak, view hanya menampilkan form.
        include 'views/salary_search.php';
        break;

    case 'refresh':
        $employeeModel->refreshDashboard();
        header("Location: index.php?action=dashboard&message=refreshed");
        break;

    default:
        $dashboard = $employeeModel->getDashboardSummary();
        include 'views/dashboard.php';
        break;
}
?>
