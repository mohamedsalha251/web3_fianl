@extends('layouts.app')

@section('title', 'About Us - Web Programming III')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Hero Section Card -->
    <div class="relative overflow-hidden rounded-2xl bg-slate-900 border border-slate-800 shadow-2xl p-8 sm:p-12 mb-8">
        <!-- Background glows -->
        <div class="absolute -top-24 -left-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-20 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 space-y-6">
            <!-- Badge -->
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider">
                <span>Practice Exercise - Week 1</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-indigo-100 to-indigo-300 tracking-tight">
                Welcome to Web Programming III
            </h1>

            <!-- Paragraph -->
            <p class="text-lg text-slate-300 leading-relaxed max-w-2xl">
                This course covers advanced server-side web application development. Throughout this practice exercises dashboard, we explore routing, controllers, views, database seeders, relationships (One-to-Many & Many-to-Many), eager loading, and soft delete capabilities.
            </p>

            <hr class="border-slate-800">

            <!-- Metadata Features -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div class="flex items-center space-x-3 text-sm text-slate-400">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span><strong>Controller:</strong> PageController.php</span>
                </div>
                <div class="flex items-center space-x-3 text-sm text-slate-400">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span><strong>View File:</strong> about.blade.php</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
