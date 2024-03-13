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
    $id = request()->route('id');
    $trail->push('Chi tiết', route('assessments.show', ['id' => $id]));
});
Breadcrumbs::for('assessments.generatePDF', function (BreadcrumbTrail $trail) {
    $trail->parent('assessments.show');
    $id = request()->route('id');
    $trail->push('Xem bản pdf', route('assessments.generatePDF', ['id' => $id]));
});

Breadcrumbs::for('assessments.addStandards', function (BreadcrumbTrail $trail) {
    $trail->parent('assessments.show');
    $id = request()->route('id');
    $trail->push('Thêm tiêu chuẩn', route('assessments.addStandards', ['id' => $id]));
});
Breadcrumbs::for('assessments.addListCriterion', function (BreadcrumbTrail $trail) {
    $trail->parent('assessments.show');
    $id = request()->route('id');
    $trail->push('Chỉnh sửa tiêu chí cho đánh giá', route('assessments.addListCriterion', ['id' => $id]));
});

Breadcrumbs::for('standards.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tiêu chuẩn', route('standards.index'));
});

Breadcrumbs::for('standards.create', function (BreadcrumbTrail $trail) {
    $trail->parent('standards.index');
    $trail->push('Tạo tiêu chuẩn', route('standards.create'));
});
Breadcrumbs::for('evidences.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Minh chứng', route('evidences.index'));
});
Breadcrumbs::for('criteria.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tiêu chí', route('criteria.index'));
});

Breadcrumbs::for('criteria.create', function (BreadcrumbTrail $trail) {
    $trail->parent('criteria.index');
    $trail->push('Tạo tiêu chí', route('criteria.create'));
});

Breadcrumbs::for('evidences.create', function ($trail) {
    $trail->parent('evidences.index');
    $trail->push('Tạo minh chứng', route('evidences.create'));
});
Breadcrumbs::for('evidences.edit', function ($trail) {
    $trail->parent('evidences.index');
    $id = request()->route('id');
    $trail->push('Chỉnh sửa minh chứng', route('evidences.edit', ['id' => $id]));
});

Breadcrumbs::for('users.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tài khoản', route('users.index'));
});
Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('users.index');
    $trail->push('Thêm tài khoản', route('users.create'));
});
