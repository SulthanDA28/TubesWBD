// import React from 'react';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend} from 'recharts';


const LineChartAssets = ({ data }:any) => {
    return (
        <LineChart
          data={data}
          width={200}
          height={100}
          margin={{
            top: 0,
            // right: 30,
            // left: -15,
            bottom: 0,
          }}
        >
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="day" />
          <YAxis />
          <Tooltip />
          <Legend />
          <Line type="monotone" dataKey="total" stroke="#8884d8" activeDot={{ r: 8 }} />
        </LineChart>
    );
}

export default LineChartAssets;