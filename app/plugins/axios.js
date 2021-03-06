export default function ( { $axios, store, redirect } ){

  $axios.onError ( error => {
    if ( error.response.status === 422 ) {
      store.dispatch ( "validation/setErrors", error.response.data.errors );
      return Promise.reject ( error );
    }
    return redirect( "/login" );
  })

  $axios.onRequest (() => {
    store.dispatch ( "validation/clearErrors" );
  })

}
