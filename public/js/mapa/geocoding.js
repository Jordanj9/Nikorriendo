class Geocoding {

    constructor(key) {
        this.key = key;
    }

    async getLatLng(location){

       const url = `https://maps.googleapis.com/maps/api/geocode/json`;

       let result = await axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
            params : {
              address:location,
              key:this.key
            }
          });

        return result.data;
    }

}
