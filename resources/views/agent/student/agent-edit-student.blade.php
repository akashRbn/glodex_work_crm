@extends('layouts.app')
@section('title', '| Edit Student')
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div
                            class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Edit Student</h4>
                            <div class="d-flex">
                                <a href="{{ route('agent_student_list') }}" class="btn btn-sm btn-secondary me-2">
                                    <i class="ti ti-arrow-back-up"
                                        style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Go Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form  action="{{ route('agent_update_student', $student->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <h6 class="badge bg-primary">General Information</h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}" placeholder="Enter student name" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $student->phone) }}" placeholder="Enter phone number" required>
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $student->email) }}" placeholder="Enter email address" required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="">--Select Gender--</option>
                                            <option value="1" {{ old('gender', $student->gender ?? '') == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ old('gender', $student->gender ?? '') == 2 ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', $student->dob) }}" required>
                                        @error('dob')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="passport_no" class="form-label">Passport Number<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="passport_no" name="passport_no" value="{{ old('passport_no', $student->passport_no) }}" placeholder="Enter passport number" required>
                                        @error('passport_no')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="fathers_name" class="form-label">Father's Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="fathers_name" name="fathers_name" value="{{ old('fathers_name', $student->fathers_name) }}" placeholder="Enter father's name." required>
                                        @error('fathers_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="mothers_name" class="form-label">Mother's Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mothers_name" name="mothers_name" value="{{ old('mothers_name', $student->mothers_name) }}" placeholder="Enter mother's name." required>
                                        @error('mothers_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="permanent_address" class="form-label">Permanent Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="permanent_address" name="permanent_address" value="{{ old('permanent_address', $student->permanent_address) }}" placeholder="Enter address (same as passport)." required>
                                        @error('permanent_address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <h6 class="badge bg-primary">English Proficiency</h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="moi" class="form-label">MOI</label>
                                        <select class="form-control" id="moi" name="moi" required>
                                            <option value="">--Select MOI--</option>
                                            <option value="1" {{ old('moi', $student->moi ?? '') == 1 ? 'selected' : '' }}>Avaiable</option>
                                            <option value="2" {{ old('moi', $student->moi ?? '') == 2 ? 'selected' : '' }}>Not Avaiable</option>
                                        </select>
                                    </div>
                                   <div id="englishTestsContainer">
                                        @if(!empty($englishTests))
                                            @foreach($englishTests as $index => $test)
                                                <div class="row english-test-row align-items-end mb-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label">English Proficiency</label>
                                                        <select class="form-control" name="english_tests[{{ $index }}][type]" required>
                                                            <option value="">--Select Proficiency--</option>
                                                            <option value="IELTS" {{ $test['type'] == 'IELTS' ? 'selected' : '' }}>IELTS</option>
                                                            <option value="PTE" {{ $test['type'] == 'PTE' ? 'selected' : '' }}>PTE</option>
                                                            <option value="TOEFL" {{ $test['type'] == 'TOEFL' ? 'selected' : '' }}>TOEFL</option>
                                                            <option value="DUOLINGO" {{ $test['type'] == 'DUOLINGO' ? 'selected' : '' }}>DUOLINGO</option>
                                                            <option value="OIETC" {{ $test['type'] == 'OIETC' ? 'selected' : '' }}>OIETC</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label class="form-label">Listening</label>
                                                        <input type="text" class="form-control" 
                                                            name="english_tests[{{ $index }}][listening]" 
                                                            placeholder="Listening"
                                                            value="{{ $test['listening'] ?? '' }}" required>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label class="form-label">Reading</label>
                                                        <input type="text" class="form-control" 
                                                            name="english_tests[{{ $index }}][reading]" 
                                                            placeholder="Reading"
                                                            value="{{ $test['reading'] ?? '' }}" required>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label class="form-label">Writing</label>
                                                        <input type="text" class="form-control" 
                                                            name="english_tests[{{ $index }}][writing]" 
                                                            placeholder="Writing"
                                                            value="{{ $test['writing'] ?? '' }}" required>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label class="form-label">Speaking</label>
                                                        <input type="text" class="form-control" 
                                                            name="english_tests[{{ $index }}][speaking]" 
                                                            placeholder="Speaking"
                                                            value="{{ $test['speaking'] ?? '' }}" required>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label class="form-label">Overall</label>
                                                        <input type="text" class="form-control" 
                                                            name="english_tests[{{ $index }}][overall]" 
                                                            placeholder="Overall"
                                                            value="{{ $test['overall'] ?? '' }}" required>
                                                    </div>

                                                    <div class="col-md-1 mt-4">
                                                        @if($loop->first)
                                                            <button type="button" class="btn btn-success add-row">+</button>
                                                        @else
                                                            <button type="button" class="btn btn-danger remove-row">−</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Default empty row when no data -->
                                            <div class="row english-test-row align-items-end mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label">English Proficiency</label>
                                                    <select class="form-control" name="english_tests[0][type]" required>
                                                        <option value="">--Select Proficiency--</option>
                                                        <option value="IELTS">IELTS</option>
                                                        <option value="PTE">PTE</option>
                                                        <option value="TOEFL">TOEFL</option>
                                                        <option value="DUOLINGO">DUOLINGO</option>
                                                        <option value="OIETC">OIETC</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-1">
                                                    <label class="form-label">Listening</label>
                                                    <input type="text" class="form-control" name="english_tests[0][listening]" placeholder="Listening" required>
                                                </div>

                                                <div class="col-md-1">
                                                    <label class="form-label">Reading</label>
                                                    <input type="text" class="form-control" name="english_tests[0][reading]" placeholder="Reading" required>
                                                </div>

                                                <div class="col-md-1">
                                                    <label class="form-label">Writing</label>
                                                    <input type="text" class="form-control" name="english_tests[0][writing]" placeholder="Writing" required>
                                                </div>

                                                <div class="col-md-1">
                                                    <label class="form-label">Speaking</label>
                                                    <input type="text" class="form-control" name="english_tests[0][speaking]" placeholder="Speaking" required>
                                                </div>

                                                <div class="col-md-1">
                                                    <label class="form-label">Overall</label>
                                                    <input type="text" class="form-control" name="english_tests[0][overall]" placeholder="Overall" required>
                                                </div>

                                                <div class="col-md-1 mt-4">
                                                    <button type="button" class="btn btn-success add-row">+</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <h6 class="badge bg-primary">Academic Qualification</h6>
                                <div class="row">
                                    <div id="academicQualificationContainer">
                                        @if(!empty($academicQualifications))
                                            @foreach($academicQualifications as $index => $qualification)
                                                <div class="row qualification-row align-items-end mb-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Group / Course Name</label>
                                                        <input type="text" class="form-control" 
                                                            name="academic_qualifications[{{ $index }}][group_name]" 
                                                            value="{{ $qualification['group_name'] ?? '' }}" 
                                                            placeholder="Enter group name" required>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Institute Name</label>
                                                        <input type="text" class="form-control" 
                                                            name="academic_qualifications[{{ $index }}][institute_name]" 
                                                            value="{{ $qualification['institute_name'] ?? '' }}" 
                                                            placeholder="Enter institute name" required>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">GPA/CGPA</label>
                                                        <input type="text" class="form-control" 
                                                            name="academic_qualifications[{{ $index }}][gpa]" 
                                                            value="{{ $qualification['gpa'] ?? '' }}" 
                                                            placeholder="Enter GPA/CGPA" required>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label class="form-label">Passing Year</label>
                                                        <input type="text" class="form-control" 
                                                            name="academic_qualifications[{{ $index }}][passing_year]" 
                                                            value="{{ $qualification['passing_year'] ?? '' }}" 
                                                            placeholder="e.g. 2023" required>
                                                    </div>

                                                    <div class="col-md-1 d-flex align-items-end">
                                                        @if($loop->first)
                                                            <button type="button" class="btn btn-success add-qualification-row">+</button>
                                                        @else
                                                            <button type="button" class="btn btn-danger remove-qualification-row">−</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Default empty row when no data -->
                                            <div class="row qualification-row align-items-end mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label">Group / Course Name</label>
                                                    <input type="text" class="form-control first-required" 
                                                        name="academic_qualifications[0][group_name]" placeholder="Enter group name" required>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">Institute Name</label>
                                                    <input type="text" class="form-control first-required" 
                                                        name="academic_qualifications[0][institute_name]" placeholder="Enter institute name" required>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">GPA/CGPA</label>
                                                    <input type="text" class="form-control first-required" 
                                                        name="academic_qualifications[0][gpa]" placeholder="Enter GPA/CGPA" required>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="form-label">Passing Year</label>
                                                    <input type="text" class="form-control first-required" 
                                                        name="academic_qualifications[0][passing_year]" placeholder="e.g. 2023" required>
                                                </div>

                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-success add-qualification-row">+</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <h6 class="badge bg-primary">Documents Upload</h6>
                                <div class="row">
                                    <h5>( Add your passport copy, All Academic Certificate & Trasnscript Record, English Proficiency and Others, name your file like firstname_lastname_filename)</h5>            
                                    @foreach($student->studentfiles as $single)
                                        <div class="col-md-3 mt-2 mb-6">
                                            <label for="documentPassport" class="form-label" style="color: #FF6D43">
                                                {{$single->filename}} <span class="text-danger">*</span>:
                                            </label>
                                            <input type="hidden" value="{{$single->filename}}" name="filename[]" class="form-control" />
                                            <div class="input-group ">
                                                <input type="file" name="studentfiles[]" class="form-control" />
                                            </div>
                                            <div id="passportDownloadLink" class="mt-2">
                                                <a href="{{ asset('storage/' . $single->filepath) }}"
                                                    class="btn btn-sm w-100 text-white" style="background: #232E51"
                                                    id="downloadPassportFile"
                                                    target="_blank">
                                                    Download Existing File
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="file_inputs" class="mt-2">
                                        <div class="row" id="f1">
                                            <div class="col-md-4">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupFile01">File Name</label>
                                                <input type="text" name="filename[]" class="form-control" />
                                            </div>
                                            </div>
                                            <div class="col-md-8">
                                            <div class="input-group mb-3">
                                                <input type="file" name="studentfiles[]" class="form-control" />
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="file_tools" class="mt-2">
                                        <div class="col-md-2">
                                            <div class="input-group mb-3">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="add_file">+</button>
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="del_file">-</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter notes..." required>{{ old('notes', $student->notes) }}</textarea>
                                    @error('notes')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END wrapper -->
@endsection
@push('page-js')
   
    {{-- function to add remove english proficiency test --}}
   <script>
        let testIndex = {{ !empty($englishTests) ? count($englishTests) : 1 }};

        document.addEventListener('click', function(e) {
            // Add new row
            if (e.target.classList.contains('add-row')) {
                e.preventDefault();

                let container = document.getElementById('englishTestsContainer');
                let firstRow = container.querySelector('.english-test-row');
                let newRow = firstRow.cloneNode(true);

                // Clear values and update input names
                newRow.querySelectorAll('input, select').forEach((el) => {
                    el.value = '';
                    el.name = el.name.replace(/\[\d+\]/, `[${testIndex}]`);
                });

                // Replace "+" button with "−"
                newRow.querySelector('.add-row').outerHTML = '<button type="button" class="btn btn-danger remove-row">−</button>';

                container.appendChild(newRow);
                testIndex++;
            }

            // Remove a row
            if (e.target.classList.contains('remove-row')) {
                e.preventDefault();
                e.target.closest('.english-test-row').remove();
            }
        });
    </script>


    {{-- Function to add remove academic qualification --}}
    <script>
        let qualificationIndex = {{ !empty($academicQualifications) ? count($academicQualifications) : 1 }};

        document.addEventListener('click', function(e) {
            // Add new academic qualification row
            if (e.target.classList.contains('add-qualification-row')) {
                e.preventDefault();

                const container = document.getElementById('academicQualificationContainer');
                const firstRow = container.querySelector('.qualification-row');
                const newRow = firstRow.cloneNode(true);

                // Clear input values and update names
                newRow.querySelectorAll('input').forEach((input) => {
                    input.value = '';
                    input.name = input.name.replace(/\[\d+\]/, `[${qualificationIndex}]`);
                });

                // Replace "+" with "−"
                newRow.querySelector('.add-qualification-row').outerHTML = '<button type="button" class="btn btn-danger remove-qualification-row">−</button>';

                container.appendChild(newRow);
                qualificationIndex++;
            }

            // Remove academic qualification row
            if (e.target.classList.contains('remove-qualification-row')) {
                e.preventDefault();
                e.target.closest('.qualification-row').remove();
            }
        });
    </script>


<script type="text/javascript">
    $(document).ready(function() {
      var counter = 2; // Start from the second input (since the first one is already present)
      $('#del_file').hide(); // Hide delete button initially
  
      // Add new file input when the add button is clicked
      $('#add_file').click(function() {
        // Create new row with the same structure
        var newRow = `
        <div class="row" id="f${counter}">
          <div class="col-md-4">
            <div class="input-group mb-3">
              <label class="input-group-text" for="inputGroupFile01">File Name</label>
              <input type="text" name="filename[]" class="form-control" required>
            </div>
          </div>
          <div class="col-md-8">
            <div class="input-group mb-3">
              <input type="file" name="studentfiles[]" class="form-control" required>
            </div>
          </div>
        </div>
      `;
  
        // Append the new row above the file tools section
        $('#file_inputs').append(newRow);
  
        // Show the delete button once we have more than one input
        $('#del_file').fadeIn(0);
  
        counter++;
      });
  
      // Delete the last file input when the delete button is clicked
      $('#del_file').click(function() {
        if (counter > 2) { // Ensure there is at least one input field left
          counter--;
          $('#f' + counter).remove();
        }
  
        // Hide delete button if only one input is left
        if (counter === 2) {
          $('#del_file').fadeOut(0);
        }
      });
    });
</script>

@endpush
