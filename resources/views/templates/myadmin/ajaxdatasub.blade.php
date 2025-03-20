<!-- Sub category-->
@if(!empty($sub_categories))
    <option value="" selected disabled>Select Sub Category</option>
    @foreach($sub_categories as $subcategory)
        <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
    @endforeach 
@endif  

@if(!empty($child_categories))
    <option value="" selected disabled>Select Child Category</option>
    @foreach($child_categories as $childcategory)
        <option value="{{$childcategory->id}}">{{$childcategory->name}}</option>
    @endforeach 
@endif 

@if(!empty($success))
    {{$success}} 
@endif 