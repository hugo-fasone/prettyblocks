export const moveBlock = (zoneStore, blockIndex: number, newIndex: number) => {
  const movedBlock = zoneStore.content[blockIndex];
  const newArray = zoneStore.content.toSpliced(blockIndex, 1);
  newArray.splice(newIndex, 0, movedBlock);
  zoneStore.content = newArray;
};
