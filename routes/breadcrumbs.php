<?php
use Diglactic\Breadcrumbs\Breadcrumbs;

use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Home', '/');
});

Breadcrumbs::for('assessments.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Đánh giá', route('assessments.index'));
});

Breadcrumbs::for('assessments.create', function (BreadcrumbTrail $trail) {
    $trail->parent('assessments.index');
    $trail->push('Tạo đánh giá', route('assessments.create'));
});

Breadcrumbs::for('assessments.show', function (BreadcrumbTrail $trail) {
    $trail->parent('assessments.index');
    $trail->push('Chi tiết', route('assessments.show',['id'=>1]));
});

Breadcrumbs::for('standards.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tiêu chuẩn', route('standards.index'));
});

Breadcrumbs::for('standards.create', function (BreadcrumbTrail $trail) {
    $trail->parent('standards.index');
    $trail->push('Tạo tiêu chuẩn', route('standards.create'));
});
