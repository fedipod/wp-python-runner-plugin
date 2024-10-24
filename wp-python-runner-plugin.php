<?php
/**
 * Plugin Name: wp-python-runner-plugin
 * Plugin URI: https://github.com/tomtaozhou/wp-python-runner-plugin
 * Description: A simple plugin to run Python scripts in WordPress.
 * Version: 1.0
 * Author: Tao Zhou
 * Author URI: https://zhouedu.net
 * License: GPL3.0
 * Requires PHP: 5.6
 * Text Domain: wp-python-runner
 * Domain Path: /languages
 */

function wp_python_runner_execute() {
    $output = '';
    // 检查表单是否已提交
    if (isset($_POST['python_code'])) {
        // 获取用户输入的 Python 代码
        $python_code = stripslashes($_POST['python_code']);  // 移除转义斜线
        
        // 将 Python 代码保存到一个临时文件中
        $python_file = plugin_dir_path(__FILE__) . 'temp_code.py';
        file_put_contents($python_file, $python_code);
        
        // 执行 Python 脚本
        $output = shell_exec("python3 " . escapeshellarg($python_file) . " 2>&1");
    }
    
    // 创建一个简单的表单来输入 Python 代码
    echo '<div class="wrap">';
    echo '<h2>Run Python Code</h2>';
    echo '<form method="post">';
    echo '<textarea name="python_code" rows="10" cols="50"></textarea><br>';
    echo '<input type="submit" value="Run Code" class="button button-primary">';
    echo '</form>';

    // 显示 Python 代码的执行输出
    if ($output) {
        echo '<h3>Output:</h3>';
        echo '<pre>' . esc_html($output) . '</pre>';
    }
    
    echo '</div>';
}

// 创建管理菜单项
function wp_python_runner_menu() {
    add_menu_page('WP Python Runner', 'Python Runner', 'manage_options', 'wp-python-runner', 'wp_python_runner_execute');
}

// 注册菜单项
add_action('admin_menu', 'wp_python_runner_menu');

?>
