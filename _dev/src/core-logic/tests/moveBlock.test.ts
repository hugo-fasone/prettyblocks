import { BlockContent } from "../entities/BlockContent";
import { PrimitiveFieldType } from "../entities/ElementType";
import { createTestingPinia } from "@pinia/testing";
import { setActivePinia } from "pinia";
import { useZoneStore } from "../store/zoneStore";

const newColumnBlock: BlockContent = {
  id: "some_random_id",
  block_id: "columnBlock",
  fields: [
    {
      id: "some_random_id",
      type: "text" as PrimitiveFieldType.TEXT,
      label: "Column block title",
      content: {
        value: "Column title",
      },
    },
    {
      id: "some_random_id",
      component_id: "banner",
      type: "component",
      label: "Banner",
      fields: [
        {
          id: "some_random_id",
          type: "text" as PrimitiveFieldType.TEXT,
          label: "Image",
          content: {
            value: "BannerImage",
          },
        },
        {
          id: "some_random_id",
          type: "text" as PrimitiveFieldType.TEXT,
          label: "Intro",
          content: {
            value: "Wonderful intro",
          },
        },
      ],
    },
    {
      id: "some_random_id",
      component_id: "column",
      type: "repeater",
      label: "Columns",
      sub_elements: [],
    },
  ],
};
const emptyBlockContent1: BlockContent = {
  id: "empty_block_content_1",
  block_id: "emptyBlock",
  fields: [],
};

const emptyBlockContent2: BlockContent = {
  id: "empty_block_content_2",
  block_id: "emptyBlock",
  fields: [],
};

describe("Move Block", () => {
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [newColumnBlock, emptyBlockContent1, emptyBlockContent2],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("moves block to given position", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content[0].block_id).toBe("columnBlock");
    expect(zoneStore.content[1].block_id).toBe("emptyBlock");
    zoneStore.moveBlock(0, 1);
    expect(zoneStore.content[1].block_id).toBe("columnBlock");
  });

  it("keeps block content", () => {
    const zoneStore = useZoneStore();
    zoneStore.moveBlock(0, 1);
    expect(zoneStore.content[1]).toEqual(newColumnBlock);
  });

  it("keeps other blocks in the right order", () => {
    const zoneStore = useZoneStore();
    zoneStore.moveBlock(0, 1);
    expect(zoneStore.content[0]).toEqual(emptyBlockContent1);
    expect(zoneStore.content[2]).toEqual(emptyBlockContent2);
  });
});
