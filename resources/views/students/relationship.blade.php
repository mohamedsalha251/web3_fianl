@extends('layouts.app')

@section('title', 'ERD & Relationships - Web Programming III')

@section('content')
<div class="max-w-7xl mx-auto space-y-10">
    
    <!-- Hero / Status Panel -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
        <div class="absolute -top-24 -left-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider">
                    <span>Practice Exercise - Weeks 3 & 4</span>
                </div>
                <h1 class="text-3xl font-extrabold text-white">Database Relationships & Soft Deletes</h1>
                <p class="text-slate-400 text-sm max-w-2xl">
                    Demonstrating Eloquent mappings (One-to-Many & Many-to-Many), eager loading performance optimizations, custom accessors, and soft deletes delete/restore workflows.
                </p>
            </div>
            
            <!-- Technical specs badge -->
            <div class="flex flex-wrap gap-2 md:self-center">
                <span class="px-3 py-1 rounded-lg bg-slate-950 border border-slate-800 text-xs text-indigo-400 font-mono">Eager Loading: Enabled</span>
                <span class="px-3 py-1 rounded-lg bg-slate-950 border border-slate-800 text-xs text-indigo-400 font-mono">Soft Deletes: Enabled</span>
            </div>
        </div>
    </div>

    <!-- Flash Success Notification -->
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-6 py-4 rounded-xl flex items-center space-x-3 shadow-lg">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- 1. ONE-TO-MANY RELATIONSHIP -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl flex flex-col">
            <div class="bg-slate-900/50 px-6 py-5 border-b border-slate-800">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                    <h2 class="text-lg font-bold text-slate-200">One-to-Many Relationship</h2>
                </div>
                <p class="text-xs text-slate-400 mt-1">
                    A Course has many primary students (represented by <code>course_id</code> in the students table).
                </p>
            </div>
            <div class="p-6 flex-grow space-y-4">
                @forelse($courses as $course)
                    <div class="p-4 rounded-xl bg-slate-950 border border-slate-800/80 hover:border-slate-700/50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-white text-sm">{{ $course->name }}</h3>
                                <p class="text-xs text-slate-500 font-mono">{{ $course->code }}</p>
                            </div>
                            <span class="text-[10px] bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 px-2 py-0.5 rounded-full font-bold">
                                {{ $course->students->count() }} Students
                            </span>
                        </div>
                        
                        <!-- Primary Students List -->
                        @if($course->students->isNotEmpty())
                            <div class="mt-3 pt-3 border-t border-slate-800/50">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Primary Students:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($course->students as $student)
                                        <span class="text-xs bg-slate-900 border border-slate-800 text-slate-300 px-2.5 py-1 rounded-md flex items-center space-x-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                                            <span>{{ $student->fullName }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-slate-500 italic mt-3 pt-3 border-t border-slate-800/50">No primary students assigned.</p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-6">No courses available.</p>
                @endforelse
            </div>
        </div>

        <!-- 2. MANY-TO-MANY RELATIONSHIP -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl flex flex-col">
            <div class="bg-slate-900/50 px-6 py-5 border-b border-slate-800">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                    <h2 class="text-lg font-bold text-slate-200">Many-to-Many Relationship (Eager Loaded)</h2>
                </div>
                <p class="text-xs text-slate-400 mt-1">
                    A Student can enroll in multiple courses (via <code>course_student</code> pivot table). Uses custom <code>fullName</code> accessor.
                </p>
            </div>
            <div class="p-6 flex-grow space-y-4">
                @forelse($students as $student)
                    <div class="p-4 rounded-xl bg-slate-950 border border-slate-800/80 hover:border-slate-700/50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-white text-sm">
                                    {{ $student->fullName }} <!-- Accessor -->
                                </h3>
                                <p class="text-xs text-slate-400">{{ $student->email }}</p>
                                @if($student->primaryCourse)
                                    <p class="text-[11px] text-indigo-400 mt-1">
                                        Major: <strong>{{ $student->primaryCourse->name }}</strong>
                                    </p>
                                @endif
                            </div>
                            <span class="text-[10px] bg-purple-500/10 border border-purple-500/20 text-purple-400 px-2 py-0.5 rounded-full font-bold">
                                {{ $student->courses->count() }} Enrolled
                            </span>
                        </div>
                        
                        <!-- Enrolled Courses -->
                        @if($student->courses->isNotEmpty())
                            <div class="mt-3 pt-3 border-t border-slate-800/50">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Enrolled Courses:</p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($student->courses as $c)
                                        <span class="text-xs bg-slate-900 border border-slate-800 text-slate-300 px-2.5 py-1 rounded-md" title="{{ $c->name }}">
                                            {{ $c->code }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-slate-500 italic mt-3 pt-3 border-t border-slate-800/50">Not enrolled in any courses.</p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-6">No students available.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 3. SOFT DELETES TESTING INTERFACE -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="bg-slate-900/50 px-6 py-5 border-b border-slate-800 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-200">Soft Deletes Testing Playground</h2>
                <p class="text-xs text-slate-400 mt-1">
                    Delete records to test soft deletes. Re-enable/restore them instantly to see them return to active state.
                </p>
            </div>
            <span class="text-xs text-amber-500 bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-full font-semibold">
                Week 4 Feature
            </span>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Students Soft Deletes -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-indigo-400 uppercase tracking-wider border-b border-slate-800 pb-2">Students (Active & Trashed)</h3>
                
                <!-- Active Students Table -->
                <div class="space-y-2">
                    <p class="text-xs text-slate-400 font-semibold">Active Students (Click to Soft Delete):</p>
                    @forelse($students as $student)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-950 border border-slate-850 hover:bg-slate-900 transition-colors">
                            <span class="text-sm text-slate-200">{{ $student->fullName }}</span>
                            <form action="/students/{{ $student->id }}/delete" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 text-xs bg-rose-600/20 hover:bg-rose-600 border border-rose-500/30 hover:border-rose-500 text-rose-400 hover:text-white rounded transition-all">
                                    Soft Delete
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 italic">No active students.</p>
                    @endforelse
                </div>

                <!-- Trashed Students Table -->
                <div class="space-y-2 pt-4">
                    <p class="text-xs text-rose-400 font-semibold flex items-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-2"></span>
                        Trashed Students (Click to Restore):
                    </p>
                    @forelse($deletedStudents as $student)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-950 border border-dashed border-rose-500/20 hover:border-rose-500/50 transition-colors">
                            <span class="text-sm text-slate-400 line-through">{{ $student->fullName }}</span>
                            <form action="/students/{{ $student->id }}/restore" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 text-xs bg-emerald-600/20 hover:bg-emerald-600 border border-emerald-500/30 hover:border-emerald-500 text-emerald-400 hover:text-white rounded transition-all">
                                    Restore
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 italic">No soft-deleted students to restore.</p>
                    @endforelse
                </div>
            </div>

            <!-- Courses Soft Deletes -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-purple-400 uppercase tracking-wider border-b border-slate-800 pb-2">Courses (Active & Trashed)</h3>
                
                <!-- Active Courses Table -->
                <div class="space-y-2">
                    <p class="text-xs text-slate-400 font-semibold">Active Courses (Click to Soft Delete):</p>
                    @forelse($courses as $course)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-950 border border-slate-850 hover:bg-slate-900 transition-colors">
                            <div>
                                <span class="text-sm text-slate-200">{{ $course->name }}</span>
                                <span class="text-[10px] text-slate-500 ml-1">({{ $course->code }})</span>
                            </div>
                            <form action="/courses/{{ $course->id }}/delete" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 text-xs bg-rose-600/20 hover:bg-rose-600 border border-rose-500/30 hover:border-rose-500 text-rose-400 hover:text-white rounded transition-all">
                                    Soft Delete
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 italic">No active courses.</p>
                    @endforelse
                </div>

                <!-- Trashed Courses Table -->
                <div class="space-y-2 pt-4">
                    <p class="text-xs text-rose-400 font-semibold flex items-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-2"></span>
                        Trashed Courses (Click to Restore):
                    </p>
                    @forelse($deletedCourses as $course)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-950 border border-dashed border-rose-500/20 hover:border-rose-500/50 transition-colors">
                            <div>
                                <span class="text-sm text-slate-400 line-through">{{ $course->name }}</span>
                                <span class="text-[10px] text-slate-650 ml-1">({{ $course->code }})</span>
                            </div>
                            <form action="/courses/{{ $course->id }}/restore" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 text-xs bg-emerald-600/20 hover:bg-emerald-600 border border-emerald-500/30 hover:border-emerald-500 text-emerald-400 hover:text-white rounded transition-all">
                                    Restore
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 italic">No soft-deleted courses to restore.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
