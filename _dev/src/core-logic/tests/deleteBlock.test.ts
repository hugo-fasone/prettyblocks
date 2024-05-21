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

describe("Delete Block", () => {
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [emptyBlockContent1, newColumnBlock, emptyBlockContent2],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("deletes specified block", () => {
    const zoneStore = useZoneStore();
    expect(zoneStore.content).toHaveLength(3);
    expect(zoneStore.content[1].block_id).toBe("columnBlock");
    zoneStore.deleteBlock(1);
    expect(zoneStore.content).toHaveLength(2);
    expect(zoneStore.content[1].block_id).toBe("emptyBlock");
  });
});
