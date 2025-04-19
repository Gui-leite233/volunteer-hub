const express = require('express');
const { PrismaClient } = require('@prisma/client');
const cors = require('cors');

const app = express();
const prisma = new PrismaClient();

app.use(cors());
app.use(express.json());

// Example endpoint to get all events
app.get('/api/events', async (req, res) => {
const events = await prisma.event.findMany({
  include: { user: true }
});
res.json(events);
});


const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
console.log(`Prisma API server running on port ${PORT}`);
});