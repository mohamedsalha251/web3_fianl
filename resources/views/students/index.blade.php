@extends('layouts.app')

@section('title', 'Students List - Web Programming III')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Title & Navigation Toggle -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-lg">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-2">
                <span>Practice Exercise - Week 2</span>
            </div>
            <h1 class="text-3xl font-extrabold text-white">Students Management</h1>
            <p class="text-sm text-slate-400 mt-1">
                Data Source: <span class="px-2 py-0.5 rounded bg-slate-800 text-indigo-400 font-mono text-xs border border-slate-700">{{ $source }}</span>
            </p>
        </div>
        
        <!-- Toggle buttons for testing empty state -->
        <div class="flex items-center space-x-2 bg-slate-950 p-1.5 rounded-lg border border-slate-800 self-start sm:self-center">
            <a href="/students" class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all {{ !Request::has('empty') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:text-white' }}">
                Show Students
            </a>
            <a href="/students?empty=true" class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all {{ Request::has('empty') ? 'bg-amber-600 text-white shadow-md shadow-amber-600/10' : 'text-slate-400 hover:text-white' }}">
                Test Empty State
            </a>
        </div>
    </div>

    <!-- Students List Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="border-b border-slate-800 bg-slate-900/50 px-6 py-4 flex items-center justify-between">
            <h2 class="font-bold text-slate-200">Registered Students</h2>
            <span class="text-xs bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 px-2.5 py-1 rounded-full font-semibold">
                Total: {{ $students->count() }}
            </span>
        </div>

        <div class="p-6">
            <ul class="divide-y divide-slate-800">
                @forelse($students as $student)
                    <li class="py-4 first:pt-0 last:pb-0 flex items-center justify-between group transition-colors duration-150 hover:bg-slate-800/10 -mx-6 px-6 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <!-- Counter Badge -->
                            <div class="w-8 h-8 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center text-sm font-bold text-slate-400 group-hover:bg-indigo-600/20 group-hover:border-indigo-500/30 group-hover:text-indigo-400 transition-colors">
                                {{ $loop->iteration }}
                            </div>
                            
                            <!-- Student Details -->
                            <div>
                                <h3 class="text-sm font-semibold text-slate-200 group-hover:text-white transition-colors">
                                    {{ $student->fullName ?? ($student->first_name . ' ' . $student->last_name) }}
                                </h3>
                                <p class="text-xs text-slate-400">{{ $student->email }}</p>
                            </div>
                        </div>
                        
                        <!-- Status Indicator -->
                        <span class="text-xs text-indigo-400 bg-indigo-500/5 px-2.5 py-1 border border-indigo-500/10 rounded-full font-mono">
                            ID: {{ $student->id }}
                        </span>
                    </li>
                @empty
                    <!-- Conditional Empty State View -->
                    <li class="py-12 text-center">
                        <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4 text-amber-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-200">No Students Found</h3>
                        <p class="text-sm text-slate-400 max-w-sm mx-auto mt-1">
                            The student list is currently empty. Click "Show Students" at the top to load fallback data or seed the database in Phase 4.
                        </p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
