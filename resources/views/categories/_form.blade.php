<x-form.input type="text" field="name" label="Name" value="{{ $category->name }}" />
<x-form.select label="Parent" name="parent_id" :options="$parents" selected="{{ $category->parent_id }}" />
