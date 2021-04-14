export async function post(props){
 const {url, data} = props;
 console.log(data);
 const response = await fetch(
  url, 
  {
   method: 'POST', // or 'PUT'
   headers: {
     'Content-Type': 'application/json',
   },
   body: JSON.stringify(data),
 })
.then(res => res.ok ? res.json() : Promise.reject(res))
.then(json => json)
.catch((error) => {
  console.error('Error:', error);
});

return response;
}