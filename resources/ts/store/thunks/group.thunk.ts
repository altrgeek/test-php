import { createAsyncThunk } from '@reduxjs/toolkit';

export const createGroup = createAsyncThunk('chat/create-group', async () => undefined);
export const deleteGroup = createAsyncThunk('chat/delete-group', async () => undefined);
export const updateGroup = createAsyncThunk('chat/update-group', async () => undefined);
export const leaveGroup = createAsyncThunk('chat/leave-group', async () => undefined);
