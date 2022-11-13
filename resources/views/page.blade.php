<form action ="{{ route('upload') }}" id="frm" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="uploadFile"/>
    <input type="submit" value="upload">
</form>