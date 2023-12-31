<!-- Row -->
<div class="row">

    <!-- Dashboard Box -->
    <div class="col-xl-12">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3><i class="icon-feather-folder-plus"></i> Job Submission Form</h3>
            </div>

            <div class="content with-padding padding-bottom-10">
                <div class="row">

                    <div class="col-xl-4">
                        <div class="submit-field">
                            <h5>Job Title</h5>
                            <x-form.input type="text" field="title" id="title" class="with-border" :value="$project->title" />
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="submit-field">
                            <h5>Job Type</h5>
                            <x-form.select name="type" id="type" :options="$types" :selected="$project->type" class="selectpicker with-border" data-size="7" title="Select Job Type" />
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="submit-field">
                            <h5>Job Category</h5>
                            <x-form.select name="category_id" id="category_id" :options="$categories" :selected="$project->category_id" class="selectpicker with-border" data-size="7" title="Select Category" />
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="submit-field">
                            <h5>Budget</h5>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="input-with-icon">
                                        <x-form.input field="budget" id="budget" :value="$project->budget" class="with-border" type="text" placeholder="Budget" />
                                        <i class="currency">USD</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="submit-field">
                            <h5>Tags <span>(optional)</span> <i class="help-icon" data-tippy-placement="right" title="Maximum of 10 tags"></i></h5>
                            <div class="keywords-container">
                                <div class="keyword-input-container">
                                    <x-form.input field="tags" id="tags" :value="implode(', ', $tags)" type="text" class="keyword-input with-border" placeholder="e.g. job title, responsibilites" />
                                    <button type="button" class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button>
                                </div>
                                <div class="keywords-list">
                                    <!-- keywords go here -->
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="submit-field">
                            <h5>Job Description</h5>
                            <x-form.textarea field="description" id="description" :value="$project->description" cols="30" rows="5" class="with-border" />
                            <div class="uploadButton margin-top-30">
                                <input class="uploadButton-input" type="file" name="attachments[]" accept="image/*, application/pdf" id="upload" multiple>
                                <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                <span class="uploadButton-file-name">Images or documents that might be helpful in describing your job</span>
                            </div>

                            <div id="imagePreview" class="margin-top-20">
                                <!-- <img  src="" alt=""> -->
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    let uploadInput = document.getElementById('upload');
                                    const imagePreview = document.getElementById('imagePreview');

                                    uploadInput.addEventListener('change', function () {
                                        const files = event.target.files;
                                        imagePreview.innerHTML = '';

                                        for (const file in files) {
                                            // Check if the file is an image
                                            if (files[file] && files[file].type.startsWith('image/')) {
                                                const reader = new FileReader();

                                                reader.onload = function (e) {
                                                    const img = document.createElement('img');
                                                    img.src = e.target.result;
                                                    img.width = 200;
                                                    img.style = 'margin: 10px 30px'
                                                    imagePreview.appendChild(img);
                                                };

                                                reader.readAsDataURL(files[file]);
                                            }
                                        }
                                    })
                                })
                            </script>

                            @if (is_array($project->attachments))
                            <div>
                                <ul class="d-flex flex-row ">
                                    @foreach ($project->attachments as $file)
                                    <!-- <li><a href="{{ asset('storage/' . $file) }}">{{ basename($file) }}</a></li> -->
                                    <li style="list-style: none; margin: 50px">
                                        <a href="{{ asset('uploads/' . $file) }}">
                                            <img src="{{ asset('uploads/' . $file) }}" alt="" width="80">
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <button type="submit" class="button ripple-effect big margin-top-30"><i class="icon-feather-plus"></i> Post a Job</button>
    </div>

</div>
<!-- Row / End -->